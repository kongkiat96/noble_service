<?php

namespace App\Models\Settings;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkerModel extends Model
{
    use HasFactory;

    public function getDataWorker($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbm_worker AS worker')
                ->leftJoin('tbt_employee AS employee', 'worker.employee_id', '=', 'employee.ID')
                ->leftJoin('tbm_group', 'employee.map_company', '=', 'tbm_group.ID')
                ->leftJoin('tbm_department', 'tbm_group.department_id', '=', 'tbm_department.ID')
                ->leftJoin('tbm_company', 'tbm_department.company_id', '=', 'tbm_company.ID')
                ->leftJoin('tbm_class_list', 'employee.position_class', '=', 'tbm_class_list.ID')
                ->leftJoin('tbm_prefix_name', 'employee.prefix_id', '=', 'tbm_prefix_name.ID')
                ->leftJoin('tbm_province', 'employee.map_province', '=', 'tbm_province.ID')
                ->leftJoin('tbm_branch', 'employee.branch_id', '=', 'tbm_branch.id')
                ->where('worker.deleted', 0)
                ->where('employee.deleted', 0);
            $sql = $sql->select(
                'worker.id',
                'employee.employee_code',
                'employee.email',
                DB::raw('CONCAT(tbm_prefix_name.prefix_name, " ", employee.first_name, " ", employee.last_name) AS full_name'),
                'tbm_class_list.class_name',
                'employee.position_name',
                'tbm_company.company_name_th',
                'tbm_department.department_name',
                'tbm_group.group_name',
                'employee.user_class',
                'worker.status_tag',
                'tbm_branch.branch_name',
                'tbm_branch.branch_code',
                'worker.created_at',
                'worker.created_user',
                'worker.updated_at',
                'worker.updated_user',
                'worker.use_tag'
                // DB::raw('(SELECT COUNT(*) FROM tbt_sub_manager WHERE tbt_sub_manager.manager_id = manager.id AND deleted = 0) AS sub_manager_count')
            );
            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('worker.created_at', 'desc')->orderBy('worker.use_tag', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('worker.created_at', 'desc')->orderBy('worker.use_tag', 'desc')->get();
            }
            // $sql = $sql->orderBy('worker.use_tag', 'desc');
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
                    'use_tag' => $value->use_tag,
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
    public function saveDataWorker($data)
    {
        try {
            $searchData = DB::connection('mysql')->table('tbm_worker')->where('employee_id', $data['employee_id'])->where('deleted', 0)->first();

            if (empty($searchData)) {
                $data['created_at'] = now();
                $data['created_user'] = Auth::user()->emp_code;
                DB::connection('mysql')->table('tbm_worker')->insert($data);
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

    public function getDataWorkerByID($workerID)
    {
        try {
            $getData = DB::connection('mysql')->table('tbm_worker')
                ->where('tbm_worker.id', $workerID)
                ->where('tbm_worker.deleted', 0)
                ->first();
            return $getData;
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

    public function saveEditWorker($dataEdit, $workerID)
    {
        try {
            $searchData = DB::connection('mysql')->table('tbm_worker')
                ->where('employee_id', $dataEdit['employee_id'])
                ->where('id', '!=', $workerID)
                ->where('deleted', 0)
                ->first();

            if ($searchData) {
                return [
                    'status' => '23000',
                    'message' => 'Duplicate employee_id'
                ];
            } else {
                $dataEdit['updated_at'] = now();
                $dataEdit['updated_user'] = Auth::user()->emp_code;
                DB::connection('mysql')->table('tbm_worker')->where('id', $workerID)->update($dataEdit);
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
}
