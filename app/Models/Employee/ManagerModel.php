<?php

namespace App\Models\Employee;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ManagerModel extends Model
{
    use HasFactory;

    public function getDataManager($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbt_manager AS manager')
                ->leftJoin('tbt_employee AS employee', 'manager.manager_emp_id', '=', 'employee.ID')
                ->leftJoin('tbm_group', 'employee.map_company', '=', 'tbm_group.ID')
                ->leftJoin('tbm_department', 'tbm_group.department_id', '=', 'tbm_department.ID')
                ->leftJoin('tbm_company', 'tbm_department.company_id', '=', 'tbm_company.ID')
                ->leftJoin('tbm_class_list', 'employee.position_class', '=', 'tbm_class_list.ID')
                ->leftJoin('tbm_prefix_name', 'employee.prefix_id', '=', 'tbm_prefix_name.ID')
                ->leftJoin('tbm_province', 'employee.map_province', '=', 'tbm_province.ID')
                ->leftJoin('tbm_branch', 'employee.branch_id', '=', 'tbm_branch.id')
                ->where('manager.deleted', 0)
                ->where('employee.deleted', 0);
            $sql = $sql->select(
                'manager.id',
                'employee.employee_code',
                'employee.email',
                DB::raw('CONCAT(tbm_prefix_name.prefix_name, " ", employee.first_name, " ", employee.last_name) AS full_name'),
                'tbm_class_list.class_name',
                'employee.position_name',
                'tbm_company.company_name_th',
                'tbm_department.department_name',
                'tbm_group.group_name',
                'employee.user_class',
                'manager.status_tag',
                'tbm_branch.branch_name',
                'tbm_branch.branch_code',
                'manager.created_at',
                'manager.created_user',
                'manager.updated_at',
                'manager.updated_user',
                DB::raw('(SELECT COUNT(*) FROM tbt_sub_manager WHERE tbt_sub_manager.manager_id = manager.id AND deleted = 0) AS sub_manager_count')
            );
            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('manager.created_at', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('manager.created_at', 'desc')->get();
            }
            // $sql = $sql->orderBy('manager.created_at', 'desc');
            $dataCount = $sql->count();

            // dd($sql);
            $newArr = [];
            foreach ($sql as $key => $value) {
                $newArr[] = [
                    'ID' => $value->id,
                    'full_name' => $value->full_name,
                    'company_name_th' => $value->company_name_th,
                    'class_name' => $value->class_name,
                    'position_name' => $value->position_name,
                    'department_name' => $value->department_name,
                    'group_name' => $value->group_name,
                    'branch_name' => $value->branch_name,
                    'branch_code' => $value->branch_code,
                    'count_sub_manager' => $value->sub_manager_count,
                    'encrypt_id' => encrypt($value->id),
                    'status_tag' => $value->status_tag,
                    'created_at' => $value->created_at,
                    'created_user' => $value->created_user,
                    'updated_at' => !empty($value->updated_at) ? $value->updated_at : '-',
                    'updated_user' => !empty($value->updated_user) ? $value->updated_user : '-',
                    'Permission' => Auth::user()->user_system
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
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDataSubManager($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbt_sub_manager AS subManager')
                ->leftJoin('tbt_employee AS employee', 'subManager.sub_emp_id', '=', 'employee.ID')
                ->leftJoin('tbm_group', 'employee.map_company', '=', 'tbm_group.ID')
                ->leftJoin('tbm_department', 'tbm_group.department_id', '=', 'tbm_department.ID')
                ->leftJoin('tbm_company', 'tbm_department.company_id', '=', 'tbm_company.ID')
                ->leftJoin('tbm_class_list', 'employee.position_class', '=', 'tbm_class_list.ID')
                ->leftJoin('tbm_prefix_name', 'employee.prefix_id', '=', 'tbm_prefix_name.ID')
                ->leftJoin('tbm_province', 'employee.map_province', '=', 'tbm_province.ID')
                ->leftJoin('tbm_branch', 'employee.branch_id', '=', 'tbm_branch.id')
                ->where('subManager.deleted', 0)
                ->where('subManager.manager_id', $param['managerID'])
                ->where('employee.deleted', 0);
            $sql = $sql->select(
                'subManager.id',
                'employee.employee_code',
                'employee.email',
                DB::raw('CONCAT(tbm_prefix_name.prefix_name, " ", employee.first_name, " ", employee.last_name) AS full_name'),
                'tbm_class_list.class_name',
                'employee.position_name',
                'tbm_company.company_name_th',
                'tbm_department.department_name',
                'tbm_group.group_name',
                'employee.user_class',
                'subManager.status_tag',
                'tbm_branch.branch_name',
                'tbm_branch.branch_code',
                'subManager.created_at',
                'subManager.created_user',
                'subManager.updated_at',
                'subManager.updated_user'
            );
            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('subManager.created_at', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('subManager.created_at', 'desc')->get();
            }
            // $sql = $sql->orderBy('subManager.created_at', 'desc');
            $dataCount = $sql->count();

            // dd($sql);
            $newArr = [];
            foreach ($sql as $key => $value) {
                $newArr[] = [
                    'ID' => $value->id,
                    'full_name' => $value->full_name,
                    'company_name_th' => $value->company_name_th,
                    'class_name' => $value->class_name,
                    'position_name' => $value->position_name,
                    'department_name' => $value->department_name,
                    'group_name' => $value->group_name,
                    'branch_name' => $value->branch_name,
                    'branch_code' => $value->branch_code,
                    'status_tag' => $value->status_tag,
                    'created_at' => $value->created_at,
                    'created_user' => $value->created_user,
                    'updated_at' => !empty($value->updated_at) ? $value->updated_at : '-',
                    'updated_user' => !empty($value->updated_user) ? $value->updated_user : '-',
                    'Permission' => Auth::user()->user_system
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
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }
    public function saveDataManager($data)
    {
        try {
            $searchData = DB::connection('mysql')->table('tbt_manager')->where('manager_emp_id', $data['manager_emp_id'])->where('deleted', 0)->first();
            // dd($searchData);
            if (empty($searchData)) {
                $data['created_at'] = now();
                $data['created_user'] = Auth::user()->emp_code;
                DB::connection('mysql')->table('tbt_manager')->insert($data);
                $returnData = [
                    'status' => 200,
                    'message' => 'Insert Success'
                ];
            } else {
                $returnData = [
                    'status' => '23000',
                    'message' => 'Dupilicate'
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

    public function saveDataSubManager($data)
    {
        try {
            $searchData = DB::connection('mysql')->table('tbt_sub_manager')->where('sub_emp_id', $data['sub_emp_id'])->where('deleted', 0)->first();
            // dd($searchData);
            if (empty($searchData)) {
                $data['created_at'] = now();
                $data['created_user'] = Auth::user()->emp_code;
                DB::connection('mysql')->table('tbt_sub_manager')->insert($data);
                $returnData = [
                    'status' => 200,
                    'message' => 'Insert Success'
                ];
            } else {
                $returnData = [
                    'status' => '23000',
                    'message' => 'Dupilicate'
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

    public function getDataManagerByID($dataID, $tag)
    {
        try {
            $getDataManager = DB::connection('mysql');
            if ($tag == 'manager') {
                $getDataManager = $getDataManager->table('tbt_manager');
            } else {
                $getDataManager = $getDataManager->table('tbt_sub_manager');
            }
            $getDataManager = $getDataManager->where('id', $dataID)
                ->where('deleted', 0)
                ->first();
            return $getDataManager;
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

    public function saveEditManager($data, $managerID)
    {
        try {
            $searchData = DB::connection('mysql')
                ->table('tbt_manager')
                ->where('manager_emp_id', $data['manager_emp_id'])
                ->where('deleted', 0)
                ->where('id', '!=', $managerID) // ยกเว้น ID ปัจจุบัน
                ->first();

            if ($searchData) {
                return [
                    'status' => '23000',
                    'message' => 'Duplicate manager_emp_id'
                ];
            } else {
                $data['updated_at'] = now();
                $data['updated_user'] = Auth::user()->emp_code;

                DB::connection('mysql')
                    ->table('tbt_manager')
                    ->where('id', $managerID)
                    ->update($data);

                return [
                    'status' => 200,
                    'message' => 'Update Success'
                ];
            }
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


    public function saveEditSubManager($data, $subManagerID)
    {
        try {
            $searchData = DB::connection('mysql')
                ->table('tbt_sub_manager')
                ->where('sub_emp_id', $data['sub_emp_id'])
                ->where('deleted', 0)
                ->where('id', '!=', $subManagerID) // ยกเว้น ID ปัจจุบัน
                ->first();

            if ($searchData) {
                // ถ้าพบ manager_emp_id ที่ซ้ำ และไม่ใช่ของตัวเอง
                return [
                    'status' => '23000',
                    'message' => 'Duplicate manager_emp_id'
                ];
            } else {
                // ถ้าไม่ซ้ำ หรือเป็น ID เดิม
                $data['updated_at'] = now();
                $data['updated_user'] = Auth::user()->emp_code;

                DB::connection('mysql')
                    ->table('tbt_sub_manager')
                    ->where('id', $subManagerID)
                    ->update($data);

                return [
                    'status' => 200,
                    'message' => 'Update Success'
                ];
            }
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

    public function deleteManager($managerID,$tag)
    {
        try {
            $sql = DB::connection('mysql');
            if($tag == 'manager'){
                $sql = $sql->table('tbt_manager');
            } else {
                $sql = $sql->table('tbt_sub_manager');
            }
            $sql = $sql->where('id', $managerID)->update([
                'deleted' => 1,
                'updated_at' => now(),
                'updated_user' => Auth::user()->emp_code
            ]);
            $returnData = [
                'status' => 200,
                'message' => 'Delete Success'
            ];
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
}
