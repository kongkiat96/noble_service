<?php

namespace App\Models\CaseService\it;

use App\Models\Master\getDataMasterModel;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CaseServiceITModel extends Model
{
    use HasFactory;

    private $getMasterModel;

    public function __construct()
    {
        $this->getMasterModel = new getDataMasterModel();
    }

    public function getDataCaseOpenIT($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbt_case_service AS cs')
                // ->where(function ($query) use ($param) {
                //     $query->where('cs.manager_emp_id', Auth::user()->map_employee);
                // })
                ->whereIn('cs.tag_manager_approve', ['Y', 'NoManager'])
                ->whereIn('cs.case_status', ['manager_it_approve', 'manager_cctv_approve', 'manager_permission_approve'])
                ->leftJoin('tbm_category_main AS cm', 'cs.category_main', '=', 'cm.id')
                ->leftJoin('tbm_category_type AS ct', 'cs.category_type', '=', 'ct.id')
                ->leftJoin('tbm_category_detail AS cd', 'cs.category_detail', '=', 'cd.id')
                ->leftJoin('tbt_employee AS em', 'cs.manager_emp_id', '=', 'em.ID')
                ->leftJoin('tbm_prefix_name AS pre', 'em.prefix_id', '=', 'pre.ID')
                ->leftJoin('tbt_employee AS empUser', 'cs.employee_other_case', '=', 'empUser.ID')
                ->leftJoin('tbm_prefix_name AS preUser', 'empUser.prefix_id', '=', 'preUser.ID')
                ->whereIn('cs.use_tag', ['IT', 'cctv', 'permission']);

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
                    'created_user'  => $this->getMasterModel->getFullNameEmp($value->created_user, 'mapEmpCode'),
                    'updated_user'  => empty($value->updated_user) ? '-' : $this->getMasterModel->getFullNameEmp($value->updated_user, 'mapEmpCode')
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
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());

            // ส่งคืนข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDataCaseDoingIT($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbt_case_service AS cs')
                // ->where(function ($query) use ($param) {
                //     $query->where('cs.manager_emp_id', Auth::user()->map_employee);
                // })
                ->whereIn('cs.tag_manager_approve', ['Y', 'NoManager'])
                ->whereIn('cs.case_step', ['doing_case', 'reject_case', 'case_reject'])
                // ->whereNotIn('cs.category_main', $this->setWhereIn())
                ->leftJoin('tbm_category_main AS cm', 'cs.category_main', '=', 'cm.id')
                ->leftJoin('tbm_category_type AS ct', 'cs.category_type', '=', 'ct.id')
                ->leftJoin('tbm_category_detail AS cd', 'cs.category_detail', '=', 'cd.id')
                ->leftJoin('tbt_employee AS em', 'cs.manager_emp_id', '=', 'em.ID')
                ->leftJoin('tbm_prefix_name AS pre', 'em.prefix_id', '=', 'pre.ID')
                ->leftJoin('tbt_employee AS empUser', 'cs.employee_other_case', '=', 'empUser.ID')
                ->leftJoin('tbm_prefix_name AS preUser', 'empUser.prefix_id', '=', 'preUser.ID')
                ->leftJoin('tbm_status_work AS sw', 'cs.case_status', '=', 'sw.ID')
                ->whereIn('cs.use_tag', ['IT', 'cctv', 'permission']);

            $sql = $sql->where('cs.deleted', 0)
                ->select(
                    'cs.*',
                    'cm.category_main_name',
                    'ct.category_type_name',
                    'cd.category_detail_name',
                    DB::raw("CONCAT(pre.prefix_name,' ',em.first_name,' ',em.last_name) as manager_name"),
                    DB::raw("CONCAT(preUser.prefix_name,' ',empUser.first_name,' ',empUser.last_name) as employee_other_case_name"),
                    'sw.status_name'
                );

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
                    'case_status'   => $value->status_name ?? $value->case_status,
                    'employee_other_case'   => $value->employee_other_case_name,
                    'manager_name'   => $value->manager_name,
                    'case_start'   => empty($value->case_start) ? '-' : $value->case_start,
                    'created_user'  => $this->getMasterModel->getFullNameEmp($value->created_user, 'mapEmpCode'),
                    'updated_user'  => empty($value->updated_user) ? '-' : $this->getMasterModel->getFullNameEmp($value->updated_user, 'mapEmpCode')
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
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());

            // ส่งคืนข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDataCaseSuccessIT($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbt_case_service AS cs')
                // ->where(function ($query) use ($param) {
                //     $query->where('cs.manager_emp_id', Auth::user()->map_employee);
                // })
                ->whereIn('cs.tag_manager_approve', ['Y', 'NoManager'])
                ->where('cs.case_step', 'case_success')
                // ->whereNotIn('cs.category_main', $this->setWhereIn())
                ->leftJoin('tbm_category_main AS cm', 'cs.category_main', '=', 'cm.id')
                ->leftJoin('tbm_category_type AS ct', 'cs.category_type', '=', 'ct.id')
                ->leftJoin('tbm_category_detail AS cd', 'cs.category_detail', '=', 'cd.id')
                ->leftJoin('tbt_employee AS em', 'cs.manager_emp_id', '=', 'em.ID')
                ->leftJoin('tbm_prefix_name AS pre', 'em.prefix_id', '=', 'pre.ID')
                ->leftJoin('tbt_employee AS empUser', 'cs.employee_other_case', '=', 'empUser.ID')
                ->leftJoin('tbm_prefix_name AS preUser', 'empUser.prefix_id', '=', 'preUser.ID')
                ->leftJoin('tbm_status_work AS sw', 'cs.case_status', '=', 'sw.ID');
            if ($param['use_tag'] == 'permission') {
                $sql = $sql->whereIn('cs.use_tag', ['permission']);
            } else {
                $sql = $sql->whereIn('cs.use_tag', ['IT', 'cctv', 'permission']);
            }

            $sql = $sql->where('cs.deleted', 0)
                ->select(
                    'cs.*',
                    'cm.category_main_name',
                    'ct.category_type_name',
                    'cd.category_detail_name',
                    DB::raw("CONCAT(pre.prefix_name,' ',em.first_name,' ',em.last_name) as manager_name"),
                    DB::raw("CONCAT(preUser.prefix_name,' ',empUser.first_name,' ',empUser.last_name) as employee_other_case_name"),
                    'sw.status_name'
                );

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
                    'case_status'   => $value->status_name ?? $value->case_status,
                    'employee_other_case'   => $value->employee_other_case_name,
                    'manager_name'   => $value->manager_name,
                    'case_start'   => empty($value->case_start) ? '-' : $value->case_start,
                    'created_user'  => $this->getMasterModel->getFullNameEmp($value->created_user, 'mapEmpCode'),
                    'updated_user'  => empty($value->updated_user) ? '-' : $this->getMasterModel->getFullNameEmp($value->updated_user, 'mapEmpCode'),
                    'check_price'   => $value->price
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
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());

            // ส่งคืนข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDataCaseWaitApproveIT($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbt_case_service AS cs')
                // ->where(function ($query) use ($param) {
                //     $query->where('cs.manager_emp_id', Auth::user()->map_employee);
                // })
                // ->whereIn('cs.tag_manager_approve', ['Y', 'NoManager'])
                // ->whereNotIn('cs.category_main', $this->setWhereIn())
                // ->where('cs.case_status', 'manager_mt_approve')
                ->leftJoin('tbm_category_main AS cm', 'cs.category_main', '=', 'cm.id')
                ->leftJoin('tbm_category_type AS ct', 'cs.category_type', '=', 'ct.id')
                ->leftJoin('tbm_category_detail AS cd', 'cs.category_detail', '=', 'cd.id')
                ->leftJoin('tbt_employee AS em', 'cs.manager_emp_id', '=', 'em.ID')
                ->leftJoin('tbm_prefix_name AS pre', 'em.prefix_id', '=', 'pre.ID')
                ->leftJoin('tbt_employee AS empUser', 'cs.employee_other_case', '=', 'empUser.ID')
                ->leftJoin('tbm_prefix_name AS preUser', 'empUser.prefix_id', '=', 'preUser.ID')
                ->whereIn('cs.use_tag', ['IT', 'cctv', 'permission'])->whereIn('cs.tag_work', ['wait_manager_it_approve', 'wait_manager_hr_approve']);

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
                    'created_user'  => $this->getMasterModel->getFullNameEmp($value->created_user, 'mapEmpCode'),
                    'updated_user'  => empty($value->updated_user) ? '-' : $this->getMasterModel->getFullNameEmp($value->updated_user, 'mapEmpCode')
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
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }
}
