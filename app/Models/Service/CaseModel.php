<?php

namespace App\Models\Service;

use App\Models\Master\getDataMasterModel;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class CaseModel extends Model
{
    use HasFactory;
    private $getDataMasterModel;

    public function __construct()
    {
        $this->getDataMasterModel = new getDataMasterModel();
    }

    public function generateCaseTicket($tag)
    {
        try {
            // ดึงปีและเดือนปัจจุบัน
            $currentYearMonth = date('Ym');
            $currentDate = date('Ymd');

            // ตรวจสอบว่ามี Ticket ที่ตรงกับปี/เดือนนี้และ Tag นี้หรือไม่
            $lastTicket = DB::connection('mysql')
                ->table('tbt_case_service')
                ->where('ticket', 'LIKE', $tag . $currentYearMonth . '%')
                ->orderBy('ticket', 'desc')
                ->first();

            // หากมี Ticket ล่าสุดแล้ว แยกลำดับ (Sequence) ออกมา
            if ($lastTicket) {
                $lastSequence = (int)substr($lastTicket->ticket, -3); // ดึงตัวเลข 3 หลักสุดท้าย
            } else {
                $lastSequence = 0; // หากไม่มี Ticket เริ่มต้นที่ 0
            }

            // สร้าง Ticket ใหม่
            $newSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT); // ลำดับถัดไป (เติม 0 ให้ครบ 3 หลัก)
            $newTicket = $tag . $currentDate . $newSequence; // สร้าง Ticket ตามรูปแบบ

            return $newTicket; // ส่งคืน Ticket ใหม่
        } catch (Exception $exception) {
            Log::error('generateCaseTicket: Failed to generate case number - ' . $exception->getMessage());
            return null;
        }
    }
    private function compressAndStoreImage($file, $filename)
    {
        // ใช้ Intervention Image บีบอัดไฟล์ภาพ
        $image = Image::make($file->getRealPath());

        // ปรับขนาดโดยคงอัตราส่วนไว้ หากต้องการบีบอัดเพิ่มเติม
        $image->resize(1920, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $path = public_path('storage/uploads/caseService/');
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        $image->save($path . $filename, 85);
    }

    private function buildParamOpenCase($request)
    {
        $getTicket = $this->generateCaseTicket($request->input("use_tag"));

        $data = [
            'ticket'    => $getTicket,
            'case_user_open'    => Auth::user()->emp_code,
            'use_tag' => $request->input("use_tag"),
            'category_main' => $request->input("category_main"),
            'category_type' => $request->input("category_type"),
            'category_detail' => $request->input("category_detail"),
            'asset_number' => $request->input("asset_number"),
            'employee_other_case' => $request->input("employee_other_case") == null ? Auth::user()->map_employee : $request->input("employee_other_case"),
            'case_detail' => $request->input("case_detail"),
            'manager_emp_id' => $request->input("manager_emp_id"),
            'sub_emp_id' => $request->input("sub_emp_id"),
            'created_at' => date('Y-m-d H:i:s'),
            'created_user'  => Auth::user()->emp_code,
            'case_status'  => 'openCaseWaitApprove',
            'tag_work'  => 'wait_manager_approve',
            'case_step' => 'wait_manager_approve'
        ];


        if ($data['manager_emp_id'] == null) {
            if ($data['use_tag'] == 'MT') {
                $data['case_start'] = now();
                $data['case_status'] = 'wait_manager_mt_approve';
                $data['case_step'] = 'wait_manager_mt_approve';
                $data['tag_manager_approve'] = 'NoManager';
                $data['tag_work'] = 'wait_manager_mt_approve';
            } else {
                $data['case_start'] = now();
                $data['case_status'] = 'wait_manager_it_approve';
                $data['case_step'] = 'wait_manager_it_approve';
                $data['tag_manager_approve'] = 'NoManager';
                $data['tag_work'] = 'wait_manager_it_approve';
            }
        }

        // ตรวจสอบว่ามีการอัปโหลดไฟล์หรือไม่
        if ($request->hasFile('file')) {
            $files = $request->file('file');
            if (is_array($files)) {
                foreach ($files as $file) {
                    if ($file instanceof \Illuminate\Http\UploadedFile) {
                        $filename = $getTicket . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                        // บีบอัดและจัดเก็บไฟล์
                        $this->compressAndStoreImage($file, $filename);

                        $data['case_image'][] = $filename;
                    }
                }
            } else {
                if ($files instanceof \Illuminate\Http\UploadedFile) {
                    $filename = $getTicket . '_' . uniqid() . '.' . $files->getClientOriginalExtension();

                    // บีบอัดและจัดเก็บไฟล์
                    $this->compressAndStoreImage($files, $filename);

                    $data['case_image'] = $filename;
                }
            }
        }
        // dd($data);
        return $data;
    }

    public function saveOpenCaseService($request)
    {
        try {
            $data = $this->buildParamOpenCase($request);
            // เก็บข้อมูล case_image ไว้ในตัวแปรก่อน unset
            $caseImages = isset($data['case_image']) ? $data['case_image'] : [];
            unset($data['case_image']);

            // บันทึกข้อมูลในตาราง tbt_case_service
            $insertCase = $data;
            $caseService = DB::connection('mysql')->table('tbt_case_service')->insertGetId($insertCase);

            // หากการบันทึกสำเร็จ
            if ($caseService) {
                // บันทึกประวัติลงในตาราง tbt_case_service_history
                DB::connection('mysql')->table('tbt_case_service_history')->insert([
                    'case_service_id' => $caseService,
                    'ticket' => $data['ticket'],
                    'case_step' => $data['case_step'],
                    'case_status' => $data['case_status'],
                    'case_detail' => $data['case_detail'],
                    'tag_work' => $data['tag_work'],
                    'created_at' => now(),
                    'created_user'  => Auth::user()->emp_code
                ]);

                // หากมี case_image ให้บันทึกลงใน tbt_case_pic
                if (!empty($caseImages)) {
                    $casePicData = [];
                    foreach ($caseImages as $image) {
                        $casePicData[] = [
                            'case_service_id' => $caseService,
                            'ticket' => $data['ticket'],
                            'pic_name'  => $image,
                            'pic_tag'   => $data['case_step'],
                            'created_at' => now(),
                            'created_user'  => Auth::user()->emp_code
                        ];
                    }

                    // บันทึกข้อมูลทั้งหมดในตาราง tbt_case_pic
                    DB::connection('mysql')->table('tbt_case_pic')->insert($casePicData);
                }
            }
            $returnData = [
                'status' => 200,
                'message' => 'Insert Success'
            ];
            // ส่งคืนข้อมูล caseService
            return $returnData;
        } catch (Exception $e) {
            // บันทึกข้อผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());

            // ส่งคืนข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDataCaseAll($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbt_case_service AS cs')
                ->where(function ($query) use ($param) {
                    $query->where('cs.case_user_open', Auth::user()->emp_code)
                        // ->orWhere('cs.manager_emp_id', Auth::user()->map_employee)
                        ->orWhere('cs.sub_emp_id', Auth::user()->map_employee);
                })
                ->leftJoin('tbm_category_main AS cm', 'cs.category_main', '=', 'cm.id')
                ->leftJoin('tbm_category_type AS ct', 'cs.category_type', '=', 'ct.id')
                ->leftJoin('tbm_category_detail AS cd', 'cs.category_detail', '=', 'cd.id')
                ->leftJoin('tbt_employee AS em', 'cs.manager_emp_id', '=', 'em.ID')
                ->leftJoin('tbm_prefix_name AS pre', 'em.prefix_id', '=', 'pre.ID')
                ->leftJoin('tbt_employee AS empUser', 'cs.employee_other_case', '=', 'empUser.ID')
                ->leftJoin('tbm_prefix_name AS preUser', 'empUser.prefix_id', '=', 'preUser.ID');
            if ($param['use_tag'] == 'IT') {
                $sql = $sql->where('cs.use_tag', 'IT');
            } else if ($param['use_tag'] == 'MT') {
                $sql = $sql->where('cs.use_tag', 'MT');
            }
            $sql = $sql->where('cs.deleted', 0)
                ->select('cs.*', 'cm.category_main_name', 'ct.category_type_name', 'cd.category_detail_name', DB::raw("CONCAT(pre.prefix_name,' ',em.first_name,' ',em.last_name) as manager_name"), DB::raw("CONCAT(preUser.prefix_name,' ',empUser.first_name,' ',empUser.last_name) as employee_other_case_name"));

            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('cs.created_at', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('cs.created_at', 'desc')->get();
            }
            $dataCount = $sql->count();
            $newArr = [];
            foreach ($sql as $key => $value) {
                if (is_numeric($value->case_status)) {
                    $caseStatus = $this->getDataMasterModel->getStatusWorkForByID($value->case_status);
                    $mapStatus = $caseStatus['status_name'];
                    $mapColor = $caseStatus['status_color'];
                } else {
                    $caseStatus = $value->case_status ?? '-';
                    $mapStatus = $caseStatus;
                    $mapColor = '#e7e7ff';
                }
                // dd($mapStatus);
                $newArr[] = [
                    'ID'    => $value->id,
                    'ticket'    => $value->ticket,
                    'category_main_name'    => $value->category_main_name,
                    'category_type_name'    => $value->category_type_name,
                    'category_detail_name'    => $value->category_detail_name,
                    'case_detail'    => $value->case_detail,
                    'created_at'    => $value->created_at,
                    'case_status'   => $mapStatus,
                    'employee_other_case'   => $value->employee_other_case_name,
                    'manager_name'   => $value->manager_name ?? '-',
                    'case_start'   => empty($value->case_start) ? '-' : $value->case_start,
                    'created_user'  => $this->getDataMasterModel->getFullNameEmp($value->created_user, 'mapEmpCode')
                ];
            }
            // dd($newArr);

            $returnData = [
                "recordsTotal" => $dataCount,
                "recordsFiltered" => $dataCount,
                "data" => $newArr,
            ];
            // dd($returnData);
            return $returnData;
        } catch (Exception $e) {
            // บันทึกข้อผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());

            // ส่งคืนข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDataCaseCheckWork($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbt_case_service AS cs')
                ->where(function ($query) use ($param) {
                    $query->where('cs.case_user_open', Auth::user()->emp_code)
                        // ->orWhere('cs.manager_emp_id', Auth::user()->map_employee)
                        ->orWhere('cs.sub_emp_id', Auth::user()->map_employee);
                })
                ->leftJoin('tbm_status_work AS sw', 'cs.case_status', '=', 'sw.ID')
                ->leftJoin('tbm_group_status AS gs', 'sw.group_status', '=', 'gs.id')
                ->leftJoin('tbm_category_main AS cm', 'cs.category_main', '=', 'cm.id')
                ->leftJoin('tbm_category_type AS ct', 'cs.category_type', '=', 'ct.id')
                ->leftJoin('tbm_category_detail AS cd', 'cs.category_detail', '=', 'cd.id')
                ->leftJoin('tbt_employee AS em', 'cs.manager_emp_id', '=', 'em.ID')
                ->leftJoin('tbm_prefix_name AS pre', 'em.prefix_id', '=', 'pre.ID')
                ->leftJoin('tbt_employee AS empUser', 'cs.employee_other_case', '=', 'empUser.ID')
                ->leftJoin('tbm_prefix_name AS preUser', 'empUser.prefix_id', '=', 'preUser.ID');
                $sql = $sql->where('gs.group_status_en', 'Success');
            $sql = $sql->where('cs.deleted', 0)
                ->select('cs.*', 'cm.category_main_name', 'ct.category_type_name', 'cd.category_detail_name', DB::raw("CONCAT(pre.prefix_name,' ',em.first_name,' ',em.last_name) as manager_name"), DB::raw("CONCAT(preUser.prefix_name,' ',empUser.first_name,' ',empUser.last_name) as employee_other_case_name"));

            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('cs.created_at', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('cs.created_at', 'desc')->get();
            }
            $dataCount = $sql->count();

            $newArr = [];
            foreach ($sql as $key => $value) {
                // if (is_numeric($value->case_status)) {d
                //     $caseStatus = $this->getDataMasterModel->getStatusWorkForByID($value->case_status);
                // } else {
                //     $caseStatus = $value->case_status ?? '-';
                // }

                if (is_numeric($value->case_status)) {
                    $caseStatus = $this->getDataMasterModel->getStatusWorkForByID($value->case_status);
                    $mapStatus = $caseStatus['status_name'];
                    $mapColor = $caseStatus['status_color'];
                } else {
                    $caseStatus = $value->case_status ?? '-';
                    $mapStatus = $caseStatus;
                    $mapColor = '#e7e7ff';
                }
                $newArr[] = [
                    'ID'    => $value->id,
                    'ticket'    => $value->ticket,
                    'category_main_name'    => $value->category_main_name,
                    'category_type_name'    => $value->category_type_name,
                    'category_detail_name'    => $value->category_detail_name,
                    'case_detail'    => $value->case_detail,
                    'created_at'    => $value->created_at,
                    'case_status'   => $mapStatus,
                    'employee_other_case'   => $value->employee_other_case_name,
                    'manager_name'   => $value->manager_name ?? '-',
                    'case_start'   => empty($value->case_start) ? '-' : $value->case_start,
                    'created_user'  => $this->getDataMasterModel->getFullNameEmp($value->created_user, 'mapEmpCode')
                ];
            }

            $returnData = [
                "recordsTotal" => $dataCount,
                "recordsFiltered" => $dataCount,
                "data" => $newArr,
            ];
            // dd($returnData);
            return $returnData;
        } catch (Exception $e) {
            // บันทึกข้อผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());

            // ส่งคืนข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDataCaseDetailApprove($getTicket)
    {
        try {
            // dd("sss");
            // Query ข้อมูลหลัก (datadetail)
            $mainQuery = DB::connection('mysql')
                ->table('tbt_case_service AS cs')
                ->leftJoin('tbm_category_main AS cm', 'cs.category_main', '=', 'cm.id')
                ->leftJoin('tbm_category_type AS ct', 'cs.category_type', '=', 'ct.id')
                ->leftJoin('tbm_category_detail AS cd', 'cs.category_detail', '=', 'cd.id')
                ->where('cs.ticket', $getTicket)
                ->where('cs.deleted', 0)
                ->select(
                    'cs.*',
                    'cm.category_main_name',
                    'ct.category_type_name',
                    'cd.category_detail_name'
                )
                ->first(); // ดึงข้อมูลแค่ 1 แถว

            // Query ข้อมูลรูปภาพ (dataimage)
            $imageQuery = DB::connection('mysql')
                ->table('tbt_case_pic')
                ->where('case_service_id', $mainQuery->id)
                ->where('pic_tag', '!=', 'doing_case')
                ->select('pic_name AS file_name')
                ->get();

            $imageQueryDoing = DB::connection('mysql')
                ->table('tbt_case_pic')
                ->where('case_service_id', $mainQuery->id)
                ->where('pic_tag', 'doing_case')
                ->select('pic_name AS file_name')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            $getGroupStatus = $this->getDataMasterModel->getGroupStatus($mainQuery->case_status);
            if($mainQuery->case_end != null && $mainQuery->sla != null){
                $calSLA = $this->getDataMasterModel->calculateSLA($mainQuery->sla, $mainQuery->case_start, $mainQuery->case_end);
            }

            // dd($calSLA);
            // สร้างโครงสร้างข้อมูลผลลัพธ์
            $data = [
                'datadetail' => [
                    'id'                    => encrypt($mainQuery->id),
                    'ticket'                => $mainQuery->ticket,
                    'category_main'         => $mainQuery->category_main,
                    'category_type'         => $mainQuery->category_type,
                    'category_detail'       => $mainQuery->category_detail,
                    'asset_number'          => $mainQuery->asset_number,
                    'employee_other_case'   => $mainQuery->employee_other_case,
                    'case_detail'           => $mainQuery->case_detail,
                    'use_tag'               => $mainQuery->use_tag,
                    'category_main_name'    => $mainQuery->category_main_name,
                    'category_type_name'    => $mainQuery->category_type_name,
                    'category_detail_name'  => $mainQuery->category_detail_name,
                    'employee_other_case_name' => $this->getDataMasterModel->getFullNameEmp($mainQuery->employee_other_case, 'mapEmpID'),
                    'manager_name'          => $mainQuery->manager_emp_id ? $this->getDataMasterModel->getFullNameEmp($mainQuery->manager_emp_id, 'mapEmpID') : null,
                    'case_item'             => $mainQuery->case_item,
                    'case_list'             => $mainQuery->case_list,
                    'worker'                => $mainQuery->worker,
                    'checker'               => $mainQuery->checker,
                    'sla'                   => $mainQuery->sla,
                    'price'                 => number_format($mainQuery->price, 2),
                    'case_status'           => $mainQuery->case_status,
                    'use_tag'               => $mainQuery->use_tag == 'IT' ? 'ไอที' : 'ช่างซ่อมบำรุง / อาคาร',
                    'use_tag_code'          => $mainQuery->use_tag,
                    'tag_work'              => $mainQuery->tag_work,
                    'group_status'          => $getGroupStatus['groupName'],
                    'case_start'            => $mainQuery->case_start,
                    'case_end'              => $mainQuery->case_end,
                    'created_at'            => $mainQuery->created_at,
                    'calSLA'                => @$calSLA
                ],
                'dataimage' => $imageQuery->toArray(), // แปลงเป็น array
                'dataimageDoing' => $imageQueryDoing->toArray()
            ];
            // dd($data);

            $returnData = [
                'status' => 200,
                'message' => $data
            ];
            return $returnData;
        } catch (Exception $e) {
            // บันทึกข้อผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());

            // ส่งคืนข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDataCaseDetailHistory($param)
    {
        try {
            // dd($param['caseID']);
            $param['caseID'] = decrypt($param['caseID']);
            // dd("ss");
            // Query ข้อมูล history
            $sql = DB::connection('mysql')
                ->table('tbt_case_service_history AS h')
                ->leftJoin('tbt_employee AS emp', 'h.created_user', '=', 'emp.employee_code')
                ->leftJoin('tbm_prefix_name AS pre', 'emp.prefix_id', '=', 'pre.ID')
                ->where('case_service_id', $param['caseID'])
                ->select(
                    'h.id AS hId',
                    'h.case_status AS hCaseStatus',
                    'h.case_detail AS hCaseDetail',
                    'h.price AS hPrice',
                    'h.created_at AS hCreatedAt',
                    'h.created_user AS hCreatedUser',
                    DB::raw("CONCAT(pre.prefix_name,' ',emp.first_name,' ',emp.last_name) AS hCreatedUserName")
                );
            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('h.created_at', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('h.created_at', 'desc')->get();
            }
            $dataCount = $sql->count();
            // dd($sql);
            $newArr = [];
            foreach ($sql as $key => $value) {
                if (is_numeric($value->hCaseStatus)) {
                    $caseStatus = $this->getDataMasterModel->getStatusWorkForByID($value->hCaseStatus);
                    $mapStatus = $caseStatus['status_name'];
                    $mapColor = $caseStatus['status_color'];
                } else {
                    $caseStatus = $value->hCaseStatus ?? '-';
                    $mapStatus = $caseStatus;
                    $mapColor = '#e7e7ff';
                }

                // dd($caseStatus['status_name']);
                $newArr[] = [
                    'ID'            => encrypt($value->hId),
                    'CaseStatus'    => $mapStatus,
                    'statusColor'   => $mapColor,
                    'CaseDetail'    => wordwrap($value->hCaseDetail, 300, "<br>", true) ?? '-',
                    'CasePrice'     => number_format($value->hPrice, 2) ?? '0.00',
                    'CreatedAt'     => $value->hCreatedAt ?? '-',
                    'CreatedUserName' => $value->hCreatedUserName ?? '-',
                ];
            }
            // dd($newArr);
            $returnData = [
                "recordsTotal" => $dataCount,
                "recordsFiltered" => $dataCount,
                "data" => $newArr,
            ];
            // dd($returnData);
            return $returnData;
        } catch (Exception $e) {
            // บันทึกข้อผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());

            // ส่งคืนข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getCategoryItem($categoryMain, $categoryType, $categoryDetail)
    {
        // dd($categoryMain, $categoryType, $categoryDetail);
        try {
            $queryDataCategory = DB::connection('mysql')->table('tbm_category_item')->where('category_main_id', $categoryMain)
                ->where('category_type_id', $categoryType)
                ->where('category_detail_id', $categoryDetail)
                ->where('status_tag', 1)
                ->where('deleted', 0)
                ->get();

            // dd($queryDataCategory);
            return $queryDataCategory;
        } catch (Exception $e) {
            // บันทึกข้อผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());

            // ส่งคืนข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getCategoryList($categoryItem)
    {
        try {
            $queryDataCategory = DB::connection('mysql')->table('tbm_category_list')
                ->where('category_item_id', $categoryItem)
                ->where('status_tag', 1)
                ->where('deleted', 0)
                ->get();

            // dd($queryDataCategory);
            return $queryDataCategory;
        } catch (Exception $e) {
            // บันทึกข้อผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());

            // ส่งคืนข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    private function buildParamDoingCaseAction($request, $caseID)
    {
        // dd($request);
        $searchData = DB::connection('mysql')->table('tbt_case_service')->where('id', $caseID)->where('deleted', 0)->first();

        // dd($request->hasFile('file'));
        if (!empty($searchData)) {
            $data['case_item']      = $request->case_item;
            $data['case_list']      = $request->case_list;
            $data['sla']            = $request->sla;
            $data['price']          =  empty($request->case_price) ? 0 : str_replace(',', '', $request->case_price);
            $data['worker']         = $request->worker;
            $data['case_status']    = $request->case_status;
            $data['case_detail']    = $request->case_doing_detail;
            $data['checker']         = $request->checker;

            if ($request->hasFile('file')) {
                $files = $request->file('file');
                if (is_array($files)) {
                    foreach ($files as $file) {
                        if ($file instanceof \Illuminate\Http\UploadedFile) {
                            $filename = $searchData->ticket . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                            // บีบอัดและจัดเก็บไฟล์
                            $this->compressAndStoreImage($file, $filename);

                            $data['case_image'][] = $filename;
                        }
                    }
                } else {
                    if ($files instanceof \Illuminate\Http\UploadedFile) {
                        $filename = $searchData->ticket . '_' . uniqid() . '.' . $files->getClientOriginalExtension();

                        // บีบอัดและจัดเก็บไฟล์
                        $this->compressAndStoreImage($files, $filename);

                        $data['case_image'] = $filename;
                    }
                }
            }
            $data['case_tag'] = 'doing_case';
        }
        // dd($data);
        return $data;
    }

    public function saveCaseDoingAction($dataRequest, $caseID)
    {
        try {
            $caseID = decrypt($caseID);
            // dd($caseID);
            $searchData = DB::connection('mysql')->table('tbt_case_service')->where('id', $caseID)->where('deleted', 0)->first();

            if ($searchData) {
                $setParam = $this->buildParamDoingCaseAction($dataRequest, $caseID);
                // dd($setParam);
                $caseImages = isset($setParam['case_image']) ? $setParam['case_image'] : [];
                unset($setParam['case_image']);
                $saveData = DB::connection('mysql')->table('tbt_case_service')->where('id', $caseID)->update([
                    'case_item' => $setParam['case_item'],
                    'case_list' => empty($setParam['case_list']) ? $searchData->case_list : $setParam['case_list'],
                    'sla' => $setParam['sla'],
                    'price' => $setParam['price'],
                    'worker' => $setParam['worker'],
                    'updated_at' => now(),
                    'updated_user' => Auth::user()->emp_code,
                    'case_step' => $setParam['case_tag'],
                    'tag_work' => $setParam['case_tag'],
                    'case_status' => $setParam['case_status'],
                    'checker' => $setParam['checker'],
                ]);

                DB::connection('mysql')->table('tbt_case_service_history')->insert([
                    'case_service_id' => $searchData->id,
                    'ticket' => $searchData->ticket,
                    'case_step' => $setParam['case_tag'],
                    'case_status' => $setParam['case_status'],
                    'case_detail' => $setParam['case_detail'],
                    'tag_work' => $setParam['case_tag'],
                    'worker' => $setParam['worker'],
                    'price' => $setParam['price'],
                    'created_at' => now(),
                    'created_user'  => Auth::user()->emp_code,
                    'checker' => $setParam['checker'],
                ]);

                // หากมี case_image ให้บันทึกลงใน tbt_case_pic
                if (!empty($caseImages)) {
                    $casePicData = [];
                    foreach ($caseImages as $image) {
                        $casePicData[] = [
                            'case_service_id' => $searchData->id,
                            'ticket' => $searchData->ticket,
                            'pic_name'  => $image,
                            'pic_tag'   => $setParam['case_tag'],
                            'created_at' => now(),
                            'created_user'  => Auth::user()->emp_code
                        ];
                    }

                    // บันทึกข้อมูลทั้งหมดในตาราง tbt_case_pic
                    DB::connection('mysql')->table('tbt_case_pic')->insert($casePicData);
                }
                return [
                    'status' => 200,
                    'message' => 'Update Success'
                ];
            } else {
                return [
                    'status' => 404,
                    'message' => 'Data Not Found'
                ];
            }
        } catch (Exception $e) {
            // บันทึกข้อผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());

            // ส่งคืนข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function realtimeCaseCheckWorkByUserCount()
    {
        try {
            $query = DB::connection('mysql')->table('tbt_case_service AS cs')
                ->where('cs.deleted', 0)
                ->where(function ($query) {
                    $query->where('cs.case_user_open', Auth::user()->emp_code)
                        ->orWhere('cs.employee_other_case', Auth::user()->map_employee);
                })
                ->leftJoin('tbm_status_work AS sw', 'cs.case_status', '=', 'sw.ID')
                ->leftJoin('tbm_group_status AS gs', 'sw.group_status', '=', 'gs.id')
                ->where('gs.group_status_en', 'Success')
                ->count();
            // dd($query);
            return $query;
        } catch (Exception $e) {
            // บันทึกข้อผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());

            // ส่งคืนข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function realtimeCaseNewCountTag($type)
    {
        try {
            $query = DB::connection('mysql')->table('tbt_case_service AS cs')
                ->where('cs.deleted', 0)
                ->whereIn('cs.tag_manager_approve', ['Y', 'NoManager']);
            switch ($type) {
                case 'it':
                $query = $query->where('cs.case_status', 'manager_it_approve')->where('cs.use_tag', 'IT');
                break;
                case 'mt':
                $query = $query->where('cs.case_status', 'manager_mt_approve')->where('cs.use_tag', 'MT');
                break;
            }
            $query = $query->count();
            return $query;
        } catch (Exception $e) {
            // บันทึกข้อผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());

            // ส่งคืนข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function realtimeCaseDoingCountTag($type)
    {
        try {
            $setTextUpercase = strtoupper($type);
            // dd($setTextUpercase);
            $query = DB::connection('mysql')->table('tbt_case_service AS cs')
                ->where('cs.deleted', 0)
                ->whereIn('cs.tag_manager_approve', ['Y', 'NoManager'])
                ->whereIn('cs.case_step', ['doing_case','reject_case','case_reject'])
                ->where('cs.use_tag', $setTextUpercase)->count();
            return $query;
        } catch (Exception $e) {
            // บันทึกข้อผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());

            // ส่งคืนข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function realtimeCaseSuccessCountTag($type)
    {
        try {
            $setTextUpercase = strtoupper($type);
            $query = DB::connection('mysql')->table('tbt_case_service AS cs')
                ->where('cs.deleted', 0)
                ->whereIn('cs.tag_manager_approve', ['Y', 'NoManager'])
                ->where('cs.case_step', 'case_success')
                ->where('cs.use_tag', $setTextUpercase)->count();
            return $query;
        } catch (Exception $e) {
            // บันทึกข้อผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());

            // ส่งคืนข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }
}
