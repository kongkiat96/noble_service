<?php

namespace App\Models\Service;

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
            'case_status'  => 'wait_manager_approve',
            'tag_work'  => 'wait_manager_approve',
        ];

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
                    'case_step' => 'openCase',
                    'tag_work' => $data['tag_work'],
                ]);

                // หากมี case_image ให้บันทึกลงใน tbt_case_pic
                if (!empty($caseImages)) {
                    $casePicData = [];
                    foreach ($caseImages as $image) {
                        $casePicData[] = [
                            'case_service_id' => $caseService,
                            'ticket' => $data['ticket'],
                            'pic_name'  => $image,
                            'pic_tag'   => 'openCase',
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
                ->select('cs.*', 'cm.category_main_name', 'ct.category_type_name', 'cd.category_detail_name', DB::raw("CONCAT(pre.prefix_name,' ',em.first_name,' ',em.last_name) as manager_name"),DB::raw("CONCAT(preUser.prefix_name,' ',empUser.first_name,' ',empUser.last_name) as employee_other_case_name"));

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
                $newArr[] = [
                    'ID'    => encrypt($value->id),
                    'ticket'    => $value->ticket,
                    'category_main_name'    => $value->category_main_name,
                    'category_type_name'    => $value->category_type_name,
                    'category_detail_name'    => $value->category_detail_name,
                    'case_detail'    => $value->case_detail,
                    'created_at'    => $value->created_at,
                    'case_status'   => $value->case_status,
                    'employee_other_case'   => $value->employee_other_case_name,
                    'manager_name'   => $value->manager_name,
                    'case_start'   => empty($value->case_start) ? '-' : $value->case_start,
                    'created_user'  => $value->created_user
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

    public function countCaseApprove($empIDmanager)
    {
        try {
            $query = DB::connection('mysql')->table('tbt_case_service AS cs')->where('cs.manager_emp_id', $empIDmanager)->where('cs.case_status', 'wait_manager_approve')->where('cs.deleted', 0)->count();
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
