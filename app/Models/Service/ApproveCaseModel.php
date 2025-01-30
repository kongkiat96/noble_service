<?php

namespace App\Models\Service;

use App\Models\Master\getDataMasterModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApproveCaseModel extends Model
{
    use HasFactory;

    private $getMasterModel;

    public function __construct()
    {
        $this->getMasterModel = new getDataMasterModel();
    }

    public function getDataCaseAll($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbt_case_service AS cs')
                ->where(function ($query) use ($param) {
                    $query->where('cs.manager_emp_id', Auth::user()->map_employee);
                })
                ->where('cs.tag_manager_approve', 'N')
                ->leftJoin('tbm_category_main AS cm', 'cs.category_main', '=', 'cm.id')
                ->leftJoin('tbm_category_type AS ct', 'cs.category_type', '=', 'ct.id')
                ->leftJoin('tbm_category_detail AS cd', 'cs.category_detail', '=', 'cd.id')
                ->leftJoin('tbt_employee AS em', 'cs.manager_emp_id', '=', 'em.ID')
                ->leftJoin('tbm_prefix_name AS pre', 'em.prefix_id', '=', 'pre.ID')
                ->leftJoin('tbt_employee AS empUser', 'cs.employee_other_case', '=', 'empUser.ID')
                ->leftJoin('tbm_prefix_name AS preUser', 'empUser.prefix_id', '=', 'preUser.ID');
            if ($param['use_tag'] == 'IT') {
                // $sql = $sql->where('cs.use_tag', 'IT');
                $sql = $sql->whereIn('cs.use_tag', ['IT','cctv','permission']);
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
                    'created_user'  => $this->getMasterModel->getFullNameEmp($value->created_user, 'mapEmpCode')
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

    public function getDataApproveMT($param)
    {
        try {
            // dd("ss");
            $sql = DB::connection('mysql')->table('tbt_case_service AS cs')
                // ->where(function ($query) use ($param) {
                //     $query->where('cs.manager_emp_id', Auth::user()->map_employee);
                // })
                ->whereIn('cs.tag_manager_approve', ['Y', 'NoManager'])
                ->leftJoin('tbm_category_main AS cm', 'cs.category_main', '=', 'cm.id')
                ->leftJoin('tbm_category_type AS ct', 'cs.category_type', '=', 'ct.id')
                ->leftJoin('tbm_category_detail AS cd', 'cs.category_detail', '=', 'cd.id')
                ->leftJoin('tbt_employee AS em', 'cs.manager_emp_id', '=', 'em.ID')
                ->leftJoin('tbm_prefix_name AS pre', 'em.prefix_id', '=', 'pre.ID')
                ->leftJoin('tbt_employee AS empUser', 'cs.employee_other_case', '=', 'empUser.ID')
                ->leftJoin('tbm_prefix_name AS preUser', 'empUser.prefix_id', '=', 'preUser.ID');
            if ($param['use_tag'] == 'IT') {
                $sql = $sql->where('cs.use_tag', 'IT')->where('cs.tag_work', 'wait_manager_it_approve');
            } else if ($param['use_tag'] == 'cctv') {
                $sql = $sql->where('cs.use_tag', 'cctv')->where('cs.tag_work', 'wait_manager_it_approve');
            } else if ($param['use_tag'] == 'permission') {
                $sql = $sql->where('cs.use_tag', 'permission')->where('cs.tag_work', 'wait_manager_hr_approve');
            } else if ($param['use_tag'] == 'MT') {
                $sql = $sql->where('cs.use_tag', 'MT')->where('cs.tag_work', 'wait_manager_mt_approve')->whereNotIn('cs.category_main', $this->setWhereIn_MT());
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
                    'created_user'  => $this->getMasterModel->getFullNameEmp($value->created_user, 'mapEmpCode')
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

    public function getDataApproveFU($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbt_case_service AS cs')
                // ->where(function ($query) use ($param) {
                //     $query->where('cs.manager_emp_id', Auth::user()->map_employee);
                // })
                ->whereIn('cs.tag_manager_approve', ['Y', 'NoManager'])
                ->whereIn('cs.category_main', $this->setWhereIn_MT())
                ->where('cs.tag_work', 'wait_manager_mt_approve')
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

    public function getDataCaseCheckWork($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbt_case_service AS cs')
                // ->where(function ($query) use ($param) {
                //     $query->where('cs.manager_emp_id', Auth::user()->map_employee);
                // })
                ->whereIn('cs.tag_manager_approve', ['Y', 'NoManager'])
                // ->whereNotIn('cs.category_main', $this->setWhereIn_MT())
                ->where('cs.tag_work', 'case_success_user')
                ->where('cs.tag_user_approve', 'Y')
                ->leftJoin('tbm_category_main AS cm', 'cs.category_main', '=', 'cm.id')
                ->leftJoin('tbm_category_type AS ct', 'cs.category_type', '=', 'ct.id')
                ->leftJoin('tbm_category_detail AS cd', 'cs.category_detail', '=', 'cd.id')
                ->leftJoin('tbt_employee AS em', 'cs.manager_emp_id', '=', 'em.ID')
                ->leftJoin('tbm_prefix_name AS pre', 'em.prefix_id', '=', 'pre.ID')
                ->leftJoin('tbt_employee AS empUser', 'cs.employee_other_case', '=', 'empUser.ID')
                ->leftJoin('tbm_prefix_name AS preUser', 'empUser.prefix_id', '=', 'preUser.ID');
            if ($param['use_tag'] == 'IT') {
                $sql = $sql->whereIn('cs.use_tag', ['IT', 'permission']);
            } else if ($param['use_tag'] == 'cctv') {
                $sql = $sql->where('cs.use_tag', 'cctv');
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
                    'created_user'  => $this->getMasterModel->getFullNameEmp($value->created_user, 'mapEmpCode')
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

    public function saveApproveCaseManager($data, $caseID)
    {
        try {
            // dd($data);
            $getDataCase = DB::connection('mysql')->table('tbt_case_service')->where('id', $caseID)->first();
            if ($data['case_status'] == 'manager_approve') {
                if ($getDataCase->use_tag == 'MT') {
                    $case_step = 'wait_manager_mt_approve';
                } else if ($getDataCase->use_tag == 'permission') {
                    $case_step = 'wait_manager_hr_approve';
                }else {
                    $case_step = 'wait_manager_it_approve';
                }
            } else {
                $case_step      = $data['case_status'];
            }



            // dd($case_step,$case_status);
            if ($getDataCase) {
                $updateCase = DB::connection('mysql')->table('tbt_case_service')->where('id', $caseID)->update([
                    'case_status' => $data['case_status'] . '_' . $getDataCase->use_tag,
                    'case_step' => $case_step,
                    'tag_manager_approve'   => 'Y',
                    'tag_work'   => $case_step,
                    'case_start' => now(),
                ]);

                $insertHistory = DB::connection('mysql')->table('tbt_case_service_history')->insert([
                    'case_service_id' => $caseID,
                    'ticket' => $getDataCase->ticket,
                    'case_status' => $data['case_status'] . '_' . $getDataCase->use_tag,
                    'case_step' => $case_step,
                    'tag_work' => $case_step,
                    'case_detail'   => $data['case_approve_detail'],
                    'created_at' => now(),
                    'created_user'  => Auth::user()->emp_code
                ]);

                $returnData = [
                    'status' => 200,
                    'message' => 'success'
                ];
            } else {
                $returnData = [
                    'status' => 404,
                    'message' => 'case not found'
                ];
            }

            return $returnData;
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function saveApproveCasePadding($data, $caseID)
    {
        try {
            // dd($data); 
            $getDataCase = DB::connection('mysql')->table('tbt_case_service')->where('id', $caseID)->first();
            // if($getDataCase->use_tag == 'MT'){
            //     $case_step = 'wait_manager_mt_approve';
            //     $case_status = 'manager_approve';
            // } else {
            //     $case_step = 'manager_approve';
            //     $case_status = 'manager_approve';
            // }
            $case_step = $data['case_status'];
            $case_status = $data['case_status'];
            if ($getDataCase) {
                $updateCase = DB::connection('mysql')->table('tbt_case_service')->where('id', $caseID)->update([
                    'case_status' => $case_status,
                    'case_step' => $case_step,
                    'tag_manager_approve'   => 'Y',
                    'tag_work'   => $case_step,
                    'case_start' => now(),
                ]);

                $insertHistory = DB::connection('mysql')->table('tbt_case_service_history')->insert([
                    'case_service_id' => $caseID,
                    'ticket' => $getDataCase->ticket,
                    'case_status' => $case_status,
                    'case_step' => $case_step,
                    'tag_work' => $case_step,
                    'case_detail'   => $data['case_approve_detail'],
                    'created_at' => now(),
                    'created_user'  => Auth::user()->emp_code
                ]);

                $returnData = [
                    'status' => 200,
                    'message' => 'success'
                ];
            } else {
                $returnData = [
                    'status' => 404,
                    'message' => 'case not found'
                ];
            }

            return $returnData;
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function realtimeCaseCountManagerApprove($empIDmanager)
    {
        try {
            $query = DB::connection('mysql')->table('tbt_case_service AS cs')->where('cs.manager_emp_id', $empIDmanager)->where('cs.case_status', 'openCaseWaitApprove')->where('cs.deleted', 0)->count();
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

    public function countCaseApproveType($type)
    {
        try {
            $query = DB::connection('mysql')->table('tbt_case_service AS cs')
                ->where('cs.deleted', 0);
            switch ($type) {
                case 'it':
                    $query = $query->where('cs.tag_work', 'wait_manager_it_approve')
                        ->where('cs.use_tag', 'IT')->whereIn('cs.tag_manager_approve', ['Y', 'NoManager']);
                    break;
                case 'cctv':
                    $query = $query->where('cs.tag_work', 'wait_manager_it_approve')
                        ->where('cs.use_tag', 'cctv')->whereIn('cs.tag_manager_approve', ['Y', 'NoManager']);
                    break;
                case 'permission':
                    $query = $query->where('cs.tag_work', 'wait_manager_hr_approve')
                        ->where('cs.use_tag', 'permission')->whereIn('cs.tag_manager_approve', ['Y', 'NoManager']);
                    break;
                case 'mt':
                    // $query = $query->whereIn('cs.category_main', $this->setWhereIn_MT())
                    $query = $query->where('cs.tag_work', 'wait_manager_mt_approve')
                        ->where('cs.use_tag', 'MT')->whereIn('cs.tag_manager_approve', ['Y', 'NoManager']);
                    break;
                case 'userCheckCase':
                    $query = $query->where('cs.manager_emp_id', Auth::user()->map_employee)->where('cs.case_status', 'openCaseWaitApprove')->whereIn('cs.tag_manager_approve', ['Y', 'NoManager']);
                    break;
                case 'managet-approve-user-it':
                    $query = $query->where('cs.manager_emp_id', Auth::user()->map_employee)->whereIn('cs.tag_manager_approve', ['N'])->whereIn('cs.use_tag', ['IT','cctv','permission']);
                    break;
                case 'managet-approve-user-mt':
                    $query = $query->where('cs.manager_emp_id', Auth::user()->map_employee)->whereIn('cs.tag_manager_approve', ['N'])->where('cs.use_tag', 'MT');
                    break;
            }

            $query = $query->count();
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



    public function countCaseApproveSubSet($type)
    {
        try {
            $query = DB::connection('mysql')->table('tbt_case_service AS cs')
                ->where('cs.deleted', 0)
                ->whereIn('cs.tag_manager_approve', ['Y', 'NoManager']);
            switch ($type) {
                case 'cctv':
                    $query = $query->whereIn('cs.category_main', $this->setWhereIn_MT())
                        // ->where('cs.tag_work', 'wait_manager_mt_approve')
                        ->where('cs.use_tag', 'IT');
                    break;
                case 'furniture':
                    $query = $query->whereIn('cs.category_main', $this->setWhereIn_MT())
                        ->where('cs.tag_work', 'wait_manager_mt_approve')
                        ->where('cs.use_tag', 'MT');
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
    public function countCaseCheckWork($type)
    {
        try {
            $setTextUpercase = strtoupper($type);
            // dd($setTextUpercase);
            $query = DB::connection('mysql')->table('tbt_case_service AS cs')
                ->where('cs.deleted', 0)
                ->whereIn('cs.tag_manager_approve', ['Y', 'NoManager'])
                // ->whereIn('cs.category_main', $this->setWhereIn_MT())
                ->where('cs.tag_work', 'case_success_user')
                ->where('cs.tag_user_approve', 'Y');
                if(in_array($setTextUpercase, ['IT'])) {
                    $query = $query->whereIn('cs.use_tag', ['IT','permission'])->count();
                } else {
                    $query = $query->where('cs.use_tag', $setTextUpercase)->count();
                }
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
    private function setWhereIn_MT()
    {
        $forCategoryMainFU = [99999999999999];
        return $forCategoryMainFU;
    }

    public function saveCaseCheckWork($saveStatus, $caseID)
    {
        try {
            // dd($saveStatus);
            $getDataCase = DB::connection('mysql')->table('tbt_case_service')->where('id', $caseID)->first();
            if(in_array($getDataCase->use_tag, ['IT', 'cctv', 'permission'])) {
                $setTextLower = strtolower('IT');
            } else {
                $setTextLower = strtolower($getDataCase->use_tag);
            }
            // dd($setTextLower);
            // dd($saveStatus, $caseID);
            // dd($getDataCase);
            if ($saveStatus['tagStep'] == 'userCheckWork') {
                $caseStatus = $saveStatus['case_status'];

                $setUpdate = [
                    'caseStatus' => $caseStatus,
                    'caseStep' => $caseStatus,
                    'tagWork' => $caseStatus,
                    'userApprove' => $caseStatus == 'case_success_user' ? 'Y' : 'N',
                    'dateEnd' => $caseStatus == 'case_success_user' ? now() : null,
                    'caseDetail'    => $caseStatus == 'case_success_user' ? 'ผ่านการตรวจสอบจากผู้แจ้ง' : 'ไม่ผ่านการตรวจสอบจากผู้แจ้ง',
                    'casePrice' => $getDataCase->price
                ];
            } else if ($saveStatus['tagStep'] == 'managerCheckWork') {
                $caseStatus = $saveStatus['case_status'];

                $mapStatus = $caseStatus == 'manager_' . $setTextLower . '_checkwork_success' ? 'case_success' : 'case_reject';
                $setUpdate = [
                    'caseStatus' => $mapStatus,
                    'caseStep' => $mapStatus,
                    'tagWork' => $mapStatus,
                    'userApprove' => $mapStatus == 'case_success' ? 'Y' : 'N',
                    'dateEnd' => $mapStatus == 'case_success' ? $getDataCase->case_end : null,
                    'caseDetail' => !empty($saveStatus['case_detail'])
                        ? $saveStatus['case_detail']
                        : ($caseStatus == 'manager_' . $setTextLower . '_checkwork_success'
                            ? 'ผ่านการตรวจสอบจากผู้จัดการฝ่าย'
                            : 'ไม่ผ่านการตรวจสอบจากผู้จัดการฝ่าย'),
                    'casePrice' => $getDataCase->price
                ];
            } else if ($saveStatus['tagStep'] == 'add_price') {
                $setUpdate = [
                    'caseStatus' => $getDataCase->case_status,
                    'caseStep' => $getDataCase->case_step,
                    'tagWork' => $getDataCase->tag_work,
                    'dateEnd'   => $getDataCase->case_end,
                    'userApprove' => $getDataCase->tag_user_approve,
                    'caseDetail' => !empty($saveStatus['case_detail']) ? $saveStatus['case_detail'] . ' / บันทึกค่าใช้จ่ายจากเจ้าหน้าที่'  : 'บันทึกค่าใช้จ่ายจากเจ้าหน้าที่',
                    'casePrice' => str_replace(',', '', $saveStatus['case_price'])

                ];
            }

            // dd($setUpdate);
            $setUpdateTime = Carbon::now();
            $setUpdateUSer = Auth::user()->emp_code;
            if ($getDataCase) {
                $updateCase = DB::connection('mysql')->table('tbt_case_service')->where('id', $caseID)->update([
                    'case_status' => $setUpdate['caseStatus'],
                    'case_step' => $setUpdate['caseStep'],
                    'tag_user_approve'   =>  $setUpdate['userApprove'],
                    'tag_work'   => $setUpdate['tagWork'],
                    'price' => $setUpdate['casePrice'],
                    'case_end' => $setUpdate['dateEnd'],
                    'updated_at' => $setUpdateTime,
                    'updated_user' => $setUpdateUSer
                ]);

                $insertHistory = DB::connection('mysql')->table('tbt_case_service_history')->insert([
                    'case_service_id' => $caseID,
                    'ticket' => $getDataCase->ticket,
                    'case_status' => $setUpdate['caseStatus'],
                    'case_step' => $setUpdate['caseStep'],
                    'tag_work' => $setUpdate['tagWork'],
                    'case_detail'   => $setUpdate['caseDetail'],
                    'created_at' => now(),
                    'created_user'  => Auth::user()->emp_code,
                    'price' => $setUpdate['casePrice']
                ]);
            }

            return [
                'status' => 200,
                'message' => 'success'
            ];
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

    public function saveChangeCategory($setInput, $caseID)
    {
        try {
            $updateCase = DB::connection('mysql')->table('tbt_case_service')->where('id', $caseID)->update([
                'category_main' => $setInput['category_main'],
                'category_type' => $setInput['category_type'],
                'category_detail' => $setInput['category_detail'],
                'updated_at' => now(),
                'updated_user' => Auth::user()->emp_code
            ]);

            return [
                'status' => 200,
                'message' => 'success'
            ];
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
