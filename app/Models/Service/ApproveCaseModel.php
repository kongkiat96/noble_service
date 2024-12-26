<?php

namespace App\Models\Service;

use App\Models\Master\getDataMasterModel;
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
            $sql = DB::connection('mysql')->table('tbt_case_service AS cs')
                // ->where(function ($query) use ($param) {
                //     $query->where('cs.manager_emp_id', Auth::user()->map_employee);
                // })
                ->whereIn('cs.tag_manager_approve', ['Y', 'NoManager'])
                ->whereNotIn('cs.category_main', $this->setWhereIn())
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
                ->whereIn('cs.category_main', $this->setWhereIn())
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

    public function saveApproveCaseManager($data, $caseID)
    {
        try {
            // dd($data);
            $getDataCase = DB::connection('mysql')->table('tbt_case_service')->where('id', $caseID)->first();
            if ($data['case_status'] == 'manager_approve') {
                if ($getDataCase->use_tag == 'MT') {
                    $case_step = 'wait_manager_mt_approve';
                } else {
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

    public function countCaseApprove($empIDmanager)
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

    public function countCaseApproveMT()
    {
        try {
            $query = DB::connection('mysql')->table('tbt_case_service AS cs')
                ->where('cs.deleted', 0)
                ->whereIn('cs.tag_manager_approve', ['Y', 'NoManager'])
                ->whereNotIn('cs.category_main', $this->setWhereIn())
                ->where('cs.tag_work', 'wait_manager_mt_approve')
                ->where('cs.use_tag', 'MT')->count();
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

    public function countCaseApproveFU()
    {
        try {
            $query = DB::connection('mysql')->table('tbt_case_service AS cs')
                ->where('cs.deleted', 0)
                ->whereIn('cs.tag_manager_approve', ['Y', 'NoManager'])
                ->whereIn('cs.category_main', $this->setWhereIn())
                ->where('cs.tag_work', 'wait_manager_mt_approve')
                ->where('cs.use_tag', 'MT')->count();
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

    private function setWhereIn()
    {
        $forCategoryMainFU = [433];
        return $forCategoryMainFU;
    }
}
