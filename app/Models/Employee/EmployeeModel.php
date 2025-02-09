<?php

namespace App\Models\Employee;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class EmployeeModel extends Model
{
    use HasFactory;

    private $getDatabase;

    public function __construct()
    {
        $this->getDatabase = DB::connection('mysql');
    }

    public function getDataEmployeeCurrent($param)
    {
        try {
            $sql = $this->getDatabase->table('tbt_employee')
                ->leftJoin('tbm_group', 'tbt_employee.map_company', '=', 'tbm_group.ID')
                ->leftJoin('tbm_department', 'tbm_group.department_id', '=', 'tbm_department.ID')
                ->leftJoin('tbm_company', 'tbm_department.company_id', '=', 'tbm_company.ID')
                ->leftJoin('tbm_class_list', 'tbt_employee.position_class', '=', 'tbm_class_list.ID')
                ->leftJoin('tbm_prefix_name', 'tbt_employee.prefix_id', '=', 'tbm_prefix_name.ID')
                ->leftJoin('tbm_province', 'tbt_employee.map_province', '=', 'tbm_province.ID')
                ->leftJoin('tbm_branch', 'tbt_employee.branch_id', '=', 'tbm_branch.id')
                ->where('tbt_employee.deleted', 0)
                ->whereIn('tbt_employee.status_login', [0,1])
                ->select(
                    'tbt_employee.ID',
                    'tbt_employee.employee_code',
                    'tbt_employee.email',
                    DB::raw('CONCAT(tbm_prefix_name.prefix_name, " ", tbt_employee.first_name, " ", tbt_employee.last_name) AS full_name'),
                    'tbm_class_list.class_name',
                    'tbt_employee.position_name',
                    'tbm_company.company_name_th',
                    'tbm_department.department_name',
                    'tbm_group.group_name',
                    'tbt_employee.user_class',
                    'status_login',
                    'tbm_branch.branch_name',
                    'tbm_branch.branch_code',
                    'tbt_employee.created_at',
                    'tbt_employee.created_user',
                    'tbt_employee.update_at',
                    'tbt_employee.update_user'
                );
            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('tbt_employee.user_class', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('tbt_employee.user_class', 'desc')->get();
            }
            // $sql = $sql->orderBy('tbt_employee.user_class', 'desc');
            $dataCount = $sql->count();

            // dd($sql);
            $newArr = [];
            foreach ($sql as $key => $value) {
                $newArr[] = [
                    'ID' =>  encrypt($value->ID),
                    'full_name' => $value->full_name,
                    'employee_code' => $value->employee_code,
                    'email' => $value->email,
                    'full_name' => $value->full_name,
                    'class_name' => $value->class_name,
                    'position_name' => $value->position_name,
                    'company_name_th' => $value->company_name_th,
                    'department_name' => $value->department_name,
                    'group_name' => $value->group_name,
                    'user_class' => $value->user_class,
                    'branch_name' => !empty($value->branch_name) && !empty($value->branch_code) ? $value->branch_name . ' (' . $value->branch_code . ')' : '-',
                    'status_login' => $value->status_login,
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
            Log::error($e->getMessage());
            return false;
        }
    }

    public function getDataEmployeeDisable($param)
    {
        try {
            $sql = $this->getDatabase->table('tbt_employee')
                ->leftJoin('tbm_group', 'tbt_employee.map_company', '=', 'tbm_group.ID')
                ->leftJoin('tbm_department', 'tbm_group.department_id', '=', 'tbm_department.ID')
                ->leftJoin('tbm_company', 'tbm_department.company_id', '=', 'tbm_company.ID')
                ->leftJoin('tbm_class_list', 'tbt_employee.position_class', '=', 'tbm_class_list.ID')
                ->leftJoin('tbm_prefix_name', 'tbt_employee.prefix_id', '=', 'tbm_prefix_name.ID')
                ->leftJoin('tbm_province', 'tbt_employee.map_province', '=', 'tbm_province.ID')
                ->leftJoin('tbm_branch', 'tbt_employee.branch_id', '=', 'tbm_branch.id')
                ->where('tbt_employee.deleted', 1)
                ->whereIn('tbt_employee.status_login', [0,1])
                ->select(
                    'tbt_employee.ID',
                    'tbt_employee.employee_code',
                    'tbt_employee.email',
                    DB::raw('CONCAT(tbm_prefix_name.prefix_name, " ", tbt_employee.first_name, " ", tbt_employee.last_name) AS full_name'),
                    'tbm_class_list.class_name',
                    'tbt_employee.position_name',
                    'tbm_company.company_name_th',
                    'tbm_department.department_name',
                    'tbm_group.group_name',
                    'tbt_employee.user_class',
                    'status_login',
                    'tbm_branch.branch_name',
                    'tbm_branch.branch_code',
                    'tbt_employee.created_at',
                    'tbt_employee.created_user',
                    'tbt_employee.update_at',
                    'tbt_employee.update_user'
                );
            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('tbt_employee.user_class', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('tbt_employee.user_class', 'desc')->get();
            }
            // $sql = $sql->orderBy('tbt_employee.user_class', 'desc');
            $dataCount = $sql->count();

            // dd($sql);
            $newArr = [];
            foreach ($sql as $key => $value) {
                $newArr[] = [
                    'ID' =>  encrypt($value->ID),
                    'full_name' => $value->full_name,
                    'employee_code' => $value->employee_code,
                    'email' => $value->email,
                    'full_name' => $value->full_name,
                    'class_name' => $value->class_name,
                    'position_name' => $value->position_name,
                    'company_name_th' => $value->company_name_th,
                    'department_name' => $value->department_name,
                    'group_name' => $value->group_name,
                    'user_class' => $value->user_class,
                    'branch_name' => !empty($value->branch_name) && !empty($value->branch_code) ? $value->branch_name . ' (' . $value->branch_code . ')' : '-',
                    'status_login' => $value->status_login,
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
            Log::error($e->getMessage());
            return false;
        }
    }

    public function saveEmployee($getData)
    {
        try {
            // dd($getData);
            $setPassword = 'P@ssw0rd#@!';
            $saveEmpGetID = $this->getDatabase->table('tbt_employee')->insertGetId([
                'employee_code' => $getData['employee_code'],
                'company_id'        => $getData['company'],
                'department_id'     => $getData['department'],
                'group_department_id'   => $getData['groupOfDepartment'],
                'map_company'       => $getData['mapIDGroup'],
                'position_class'    => $getData['positionClass'],
                'position_name'     => $getData['positionName'],
                'date_start_work'   => $getData['dateStart'],
                'date_end_work'     => $getData['dateEnd'],
                'user_class'        => $getData['userClass'],
                'status_login'      => $getData['statusLogin'],
                'prefix_id'         => $getData['prefixName'],
                'first_name'        => $getData['firstName'],
                'last_name'         => $getData['lastName'],
                'birthday'          => $getData['birthday'],
                'age'               => $getData['age'],
                'email'             => $getData['email'],
                'phone_number'      => $getData['phoneNumber'],
                'current_address'   => $getData['currentAddress'],
                'map_province'      => $getData['mapIDProvince'],
                'img_base'          => $getData['baseimg'],
                'branch_id'         => $getData['branch_id'],
                'created_at'        => Carbon::now(),
                'created_user'      => Auth::user()->emp_code
            ]);

            if (isset($saveEmpGetID)) {
                $saveUser = $this->getDatabase->table('users')->insert([
                    'name'  => $getData['firstName'] . ' ' . $getData['lastName'],
                    'email' => $getData['email'],
                    'emp_code' => $getData['employee_code'],
                    'password' => bcrypt($setPassword),
                    'created_at' => Carbon::now(),
                    'user_level' => 2,
                    'user_system'   => $getData['userClass'],
                    'map_employee' => $saveEmpGetID
                ]);
            }

            if (!empty($saveUser) && !empty($saveEmpGetID)) {
                $returnStatus = [
                    'status'    => 200,
                    'message'   => 'Success',
                ];
            } else {
                $returnStatus = [
                    'status'    => 500,
                    'message'   => 'Error',
                ];
            }
        } catch (Exception $e) {
            $returnStatus = [
                'status'    => $e->getCode(),
                'message'   => $e->getMessage()
            ];
            // Log::info($returnStatus);
        } finally {
            return $returnStatus;
        }
    }

    public function editEmployee($employeeID, $dataEmployee)
    {
        // dd($employeeID, $dataEmployee);
        try {
            $saveEditEmployeeData = $this->getDatabase->table('tbt_employee')
                ->where('ID', $employeeID)
                ->update([
                    'employee_code' => $dataEmployee['employee_code'],
                    'company_id'        => $dataEmployee['company'],
                    'department_id'     => $dataEmployee['department'],
                    'group_department_id'   => $dataEmployee['groupOfDepartment'],
                    'map_company'       => $dataEmployee['mapIDGroup'],
                    'position_class'    => $dataEmployee['positionClass'],
                    'position_name'     => $dataEmployee['positionName'],
                    'date_start_work'   => $dataEmployee['dateStart'],
                    'date_end_work'     => $dataEmployee['dateEnd'],
                    'user_class'        => $dataEmployee['userClass'],
                    'status_login'      => $dataEmployee['statusLogin'],
                    'prefix_id'         => $dataEmployee['prefixName'],
                    'first_name'        => $dataEmployee['firstName'],
                    'last_name'         => $dataEmployee['lastName'],
                    'birthday'          => $dataEmployee['birthday'],
                    'age'               => $dataEmployee['age'],
                    'email'             => $dataEmployee['email'],
                    'phone_number'      => $dataEmployee['phoneNumber'],
                    'current_address'   => $dataEmployee['currentAddress'],
                    'map_province'      => $dataEmployee['mapIDProvince'],
                    'img_base'          => $dataEmployee['baseimg'],
                    'branch_id'         => $dataEmployee['branch_id'],
                    'deleted'           => $dataEmployee['statusLogin'] == 1 ? 0 : 1,
                    'update_at'         => Carbon::now(),
                    'update_user'       => Auth::user()->emp_code
                ]);
            if ($saveEditEmployeeData == 1) {
                $saveEditUserData = $this->getDatabase->table('users')->where('map_employee', $employeeID)->update([
                    'name'          => $dataEmployee['firstName'] . ' ' . $dataEmployee['lastName'],
                    'email'         => $dataEmployee['email'],
                    'emp_code'      => $dataEmployee['employee_code'],
                    'user_system'   => $dataEmployee['userClass'],
                    'map_employee'  => $employeeID,
                    'status_login'  => $dataEmployee['statusLogin'],
                    'updated_at'    => Carbon::now()
                ]);
            }
            // dd($saveEditEmployeeData, $saveEditUserData);
            if ($saveEditEmployeeData && $saveEditUserData == 1) {
                $returnStatus = [
                    'status'    => 200,
                    'message'   => 'Success',
                ];
            } else {
                $returnStatus = [
                    'status'    => 500,
                    'message'   => 'Error',
                ];
            }
        } catch (Exception $e) {
            $returnStatus = [
                'status'    => intval($e->getCode()),
                'message'   => $e->getMessage()
            ];
            Log::info($returnStatus);
        } finally {
            return $returnStatus;
        }
    }

    public function deleteEmployee($employeeID)
    {
        try {
            $deleteData = $this->getDatabase->table('tbt_employee')->where('ID', $employeeID)->update([
                'status_login'      => 0,
                'deleted'           => 1,
                'update_user'       => Auth::user()->emp_code,
                'update_at'         => Carbon::now()
            ]);

            $deleteUser = $this->getDatabase->table('users')->where('map_employee', $employeeID)->update([
                'status_login'           => 0,
                'updated_at'             => Carbon::now()
            ]);

            $returnStatus = [
                'status'    => 200,
                'message'   => 'Delete Success'
            ];
        } catch (Exception $e) {
            $returnStatus = [
                'status'    => intval($e->getCode()),
                'message'   => $e->getMessage()
            ];
            Log::info($returnStatus);
        } finally {
            return $returnStatus;
        }
    }

    public function restoreEmployee($employeeID)
    {
        try {
            $restoreData = $this->getDatabase->table('tbt_employee')->where('ID', $employeeID)->update([
                'status_login'      => 1,
                'deleted'           => 0,
                'update_user'       => Auth::user()->emp_code,
                'update_at'         => Carbon::now()
            ]);

            $restoreUser = $this->getDatabase->table('users')->where('map_employee', $employeeID)->update([
                'status_login'           => 1,
                'updated_at'             => Carbon::now()
            ]);

            $returnStatus = [
                'status'    => 200,
                'message'   => 'Restore Success'
            ];
        } catch (Exception $e) {
            $returnStatus = [
                'status'    => intval($e->getCode()),
                'message'   => $e->getMessage()
            ];
            Log::info($returnStatus);
        } finally {
            return $returnStatus;
        }
    }

    public function resetPasswordEmployee($employeeID)
    {
        try {
            $setPassword = 'P@ssw0rd#@!';
            $resetPasswordData = $this->getDatabase->table('tbt_employee')->where('ID', $employeeID)->update([
                'update_user'       => Auth::user()->emp_code,
                'update_at'         => Carbon::now()
            ]);

            $resetPasswordUser = $this->getDatabase->table('users')->where('map_employee', $employeeID)->update([
                'password'               => bcrypt($setPassword),
                'updated_at'             => Carbon::now()
            ]);

            $returnStatus = [
                'status'    => 200,
                'message'   => 'ResetPassword Success'
            ];
        } catch (Exception $e) {
            $returnStatus = [
                'status'    => intval($e->getCode()),
                'message'   => $e->getMessage()
            ];
            Log::info($returnStatus);
        } finally {
            return $returnStatus;
        }
    }

    public function getDataEmployee($getEmpGetID)
    {
        try {
            $data = $this->getDatabase->table('tbt_employee')
                ->leftJoin('tbm_group', 'tbt_employee.map_company', '=', 'tbm_group.ID')
                ->leftJoin('tbm_class_list', 'tbt_employee.position_class', '=', 'tbm_class_list.ID')
                ->leftJoin('tbm_prefix_name', 'tbt_employee.prefix_id', '=', 'tbm_prefix_name.ID')
                ->leftJoin('tbm_province', 'tbt_employee.map_province', '=', 'tbm_province.ID')
                ->leftJoin('tbm_branch', 'tbt_employee.branch_id', '=', 'tbm_branch.id')
                ->where('tbt_employee.ID', $getEmpGetID)
                ->select('tbt_employee.*', 'tbt_employee.ID AS emp_id', 'tbm_group.*', 'tbm_group.ID AS group_id', 'tbm_class_list.*', 'tbm_class_list.ID AS class_id', 'tbm_prefix_name.*', 'tbm_prefix_name.ID AS prefix_id', 'tbm_province.*', 'tbm_province.ID AS province_id', DB::raw('CONCAT(tbm_branch.branch_name, " (", tbm_branch.branch_code, ")") AS branch_name'))
                ->first();

            // dd($data);
            return $data;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function getDataSearchEmployee($param)
    {
        try {
            $sql = $this->getDatabase->table('tbt_employee')
                ->leftJoin('tbm_group', 'tbt_employee.map_company', '=', 'tbm_group.ID')
                ->leftJoin('tbm_department', 'tbm_group.department_id', '=', 'tbm_department.ID')
                ->leftJoin('tbm_company', 'tbm_department.company_id', '=', 'tbm_company.ID')
                ->leftJoin('tbm_class_list', 'tbt_employee.position_class', '=', 'tbm_class_list.ID')
                ->leftJoin('tbm_prefix_name', 'tbt_employee.prefix_id', '=', 'tbm_prefix_name.ID')
                ->leftJoin('tbm_province', 'tbt_employee.map_province', '=', 'tbm_province.ID')
                ->leftJoin('tbm_branch', 'tbt_employee.branch_id', '=', 'tbm_branch.id');
                // ->where('tbt_employee.deleted', 0);

            if ($param['company_id'] != '') {
                $sql = $sql->where('tbt_employee.company_id', intval($param['company_id']));
            }
            if ($param['department_id'] != '') {
                $sql = $sql->where('tbt_employee.department_id', intval($param['department_id']));
            }
            if ($param['group_department_id'] != '') {
                $sql = $sql->where('tbt_employee.group_department_id', intval($param['group_department_id']));
            }
            if ($param['user_class'] != '') {
                $sql = $sql->where('tbt_employee.user_class', $param['user_class']);
            }
            if ($param['status_login'] != '') {
                // dd($param['status_login']);
                $sql = $sql->where('tbt_employee.status_login', intval($param['status_login']));
            }
            if ($param['employee_code'] != '') {
                $sql = $sql->where('tbt_employee.employee_code', 'LIKE', '%' . $param['employee_code'] . '%');
            }

            $sql = $sql->select(
                'tbt_employee.ID',
                'tbt_employee.employee_code',
                'tbt_employee.email',
                DB::raw('CONCAT(tbm_prefix_name.prefix_name, " ", tbt_employee.first_name, " ", tbt_employee.last_name) AS full_name'),
                'tbm_class_list.class_name',
                'tbt_employee.position_name',
                'tbm_company.company_name_th',
                'tbm_department.department_name',
                'tbm_group.group_name',
                'tbt_employee.user_class',
                'status_login',
                'tbm_branch.branch_name',
                'tbm_branch.branch_code',
                'tbt_employee.created_at',
                'tbt_employee.created_user',
                'tbt_employee.update_at',
                'tbt_employee.update_user'
            );
            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('tbt_employee.user_class', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('tbt_employee.user_class', 'desc')->get();
            }
            // $sql = $sql->orderBy('tbt_employee.user_class', 'desc');
            $dataCount = $sql->count();

            // dd($sql);
            $newArr = [];
            foreach ($sql as $key => $value) {
                $newArr[] = [
                    'ID' => encrypt($value->ID),
                    'full_name' => $value->full_name,
                    'employee_code' => $value->employee_code,
                    'email' => $value->email,
                    'full_name' => $value->full_name,
                    'class_name' => $value->class_name,
                    'position_name' => $value->position_name,
                    'company_name_th' => $value->company_name_th,
                    'department_name' => $value->department_name,
                    'group_name' => $value->group_name,
                    'user_class' => $value->user_class,
                    'branch_name' => !empty($value->branch_name) && !empty($value->branch_code) ? $value->branch_name . ' (' . $value->branch_code . ')' : '-',
                    'status_login' => $value->status_login,
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
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function changePassword($dataPassword)
    {
        try {
            // dd($dataPassword['newPassword']);
            $data['newPassword'] = Hash::make($dataPassword['newPassword']);
            $changePassword = $this->getDatabase->table('users')->where('id', Auth::user()->id)->update([
                'password'      => $data['newPassword'],
                'updated_at'    => now(),
            ]);
            if ($changePassword) {
                $returnData = [
                    'status'    => 200,
                    'message'   => 'Change Password Success'
                ];
            }

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
