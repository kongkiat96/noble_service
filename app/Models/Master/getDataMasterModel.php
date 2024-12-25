<?php

namespace App\Models\Master;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class getDataMasterModel extends Model
{
    use HasFactory;

    public function getDataPrefixName()
    {
        $getPrefixName = DB::connection('mysql')->table('tbm_prefix_name')
            ->select('prefix_name', 'ID')
            ->where('status', 1)
            ->where('deleted', 0)
            ->get();
        return $getPrefixName;
    }

    public function getDataProvince()
    {
        $getProvince = DB::connection('mysql')->table('tbm_province')
            ->select('province_code', 'province')
            ->where('deleted', 0)
            ->groupBy('province_code', 'province')
            ->get();
        return $getProvince;
    }

    public function getDataAmphoe($provinceCode)
    {
        $getAmphoe = DB::connection('mysql')->table('tbm_province')
            ->select('amphoe_code', 'amphoe')
            ->where('province_code', $provinceCode)
            ->where('deleted', 0)
            ->groupBy('amphoe_code', 'amphoe')
            ->get();

        return $getAmphoe;
    }

    public function getDataTambon($aumphoeCode)
    {
        $getTambon = DB::connection('mysql')->table('tbm_province')
            ->select('id', 'tambon_code', 'tambon', 'zipcode')
            ->where('amphoe_code', $aumphoeCode)
            ->where('deleted', 0)
            ->groupBy('id', 'tambon_code', 'tambon', 'zipcode')
            ->get();

        return $getTambon;
    }

    public function getProvinceID($tambonCode)
    {
        // dd($tambonCode);
        $getProvinceID = DB::connection('mysql')->table('tbm_province')
            ->select('id', 'tambon_code', 'tambon', 'zipcode')
            ->where('tambon_code', $tambonCode)
            ->get();

        return $getProvinceID;
    }

    public function getClassList()
    {
        $getClassList = DB::connection('mysql')->table('tbm_class_list')
            ->select('class_name', 'ID')
            ->where('status', 1)
            ->where('deleted', 0)
            ->get();
        return $getClassList;
    }

    public function getDataFlagType()
    {
        $getFlagType = DB::connection('mysql')->table('tbm_flag_type')
            ->select('flag_name', 'type_work', 'ID')
            ->where('deleted', 0)
            ->get();
        return $getFlagType;
    }

    public function getDataCompany()
    {
        Log::info('getDataCompany: Retrieving companies from the database.');
        try {
            $getCompany = DB::connection('mysql')->table('tbm_company')
                ->select('ID', 'company_name_th', 'company_name_en')
                ->where('status', 1)
                ->where('deleted', 0)
                ->get();

            Log::info('getDataCompany: Successfully retrieved companies.');

            return $getCompany;
        } catch (Exception $exception) {
            Log::error('getDataCompany: Failed to retrieve companies - ' . $exception->getMessage());

            throw $exception;
        }
    }

    public function getDataDepartment()
    {
        Log::info('getDataDepartment: Starting to retrieve departments.');
        try {
            $getDepartment = DB::connection('mysql')->table('tbm_department AS depart')
                ->leftJoin('tbm_company AS company', 'depart.company_id', '=', 'company.ID')
                ->select(
                    'depart.ID',
                    'depart.department_name AS departmentName',
                    'company.company_name_th AS companyName'
                )
                ->where('depart.deleted', 0)
                ->where('company.status', 1)
                ->where('company.deleted', 0)
                ->get();

            Log::info('getDataDepartment: Successfully retrieved departments.');
            // dd($getDepartment);
            return $getDepartment;
        } catch (Exception $e) {
            Log::error('getDataDepartment: Failed to retrieve departments - ' . $e->getMessage());
            throw $e;
        }
    }

    public function getDataCompanyForID($id)
    {
        // dd($id);
        $returnCompany = DB::connection('mysql')->table('tbm_department AS depart')
            ->leftJoin('tbm_company AS company', 'depart.company_id', '=', 'company.ID')
            ->select(
                'company.ID',
                'depart.department_name AS departmentName',
                'company.company_name_th AS company_name_th'
            )
            ->where('depart.ID', $id)
            ->where('depart.deleted', 0)
            ->where('company.deleted', 0)
            ->get();

        // dd($returnCompany);

        return $returnCompany;
    }

    public function getDataDepartmentForID($id)
    {
        $returnDepartment = DB::connection('mysql')->table('tbm_department AS depart')
            ->leftJoin('tbm_company AS company', 'depart.company_id', '=', 'company.ID')
            ->select(
                'depart.ID',
                'depart.department_name AS departmentName',
                'company.company_name_th AS company_name_th'
            )
            ->where('company.ID', $id)
            ->where('depart.status', 1)
            ->where('depart.deleted', 0)
            ->where('company.deleted', 0)
            ->get();

        // dd($returnDepartment);

        return $returnDepartment;
    }

    public function getDataGroupOfDepartment($departmentID)
    {
        $returnGroup = DB::connection('mysql')->table('tbm_group')
            ->select('ID', 'group_name', 'department_id')
            ->where('department_id', $departmentID)
            ->where('deleted', 0)
            ->where('status', 1)
            ->get();
        return $returnGroup;
    }

    public function getMenuMain()
    {

        $getMenuMain = DB::connection('mysql')->table('tbm_menu_main')
            ->select('ID', 'menu_name')
            ->where('deleted', 0)
            ->get();
        return $getMenuMain;
    }

    public function getMenuToAccess()
    {
        $getMenu = DB::connection('mysql')->table('tbm_menu_sub AS tms')
            ->leftJoin('tbm_menu_main AS tmm', 'tms.menu_main_id', '=', 'tmm.ID')
            ->select('tms.ID', 'tms.menu_sub_name', 'tms.menu_sub_link', 'tms.menu_main_ID', 'tmm.menu_name', 'tmm.menu_icon', 'tmm.menu_link', 'tms.menu_sub_icon', 'tms.status')
            ->where('tms.deleted', 0)
            ->orderBy('tmm.menu_sort', 'asc')
            ->orderBy('tms.ID', 'asc')
            ->get();
        return $getMenu;
    }

    public function getUserList($idMapEmployee)
    {
        $getEmployee = DB::connection('mysql')->table('users')->where('map_employee', $idMapEmployee)->get();
        return $getEmployee;
    }

    public function getAccessMenu($idMapEmployee)
    {
        $getAccessMenu = DB::connection('mysql')->table('tbt_user_access_menu')
            ->where('employee_code', $idMapEmployee)
            ->get();
        return $getAccessMenu;
    }

    public static function getMenusName($menuID)
    {
        $isDataBase = DB::connection('mysql');
        $returnMenus = $isDataBase->table('tbm_menu_sub AS tms')
            ->leftJoin('tbm_menu_main AS tmm', 'tms.menu_main_ID', '=', 'tmm.ID')
            ->whereIn('tms.ID', $menuID)
            ->where('tmm.deleted', 0)
            ->where('tmm.status', 1)
            ->where('tms.deleted', 0)
            ->where('tms.status', 1)
            ->select('tmm.ID', 'tmm.menu_link', 'menu_icon', 'tmm.menu_name', 'tms.menu_sub_name', 'tms.menu_sub_link', 'tms.menu_sub_icon')
            ->orderBy('tmm.menu_sort', 'asc')
            ->orderBy('tms.ID', 'asc')
            ->get();
        // จัดกลุ่มเมนูหลักและย่อย
        $groupedMenus = [];
        foreach ($returnMenus as $menu) {
            $groupedMenus[$menu->menu_name]['main'] = [
                'ID' => $menu->ID,
                'menu_link' => $menu->menu_link,
                'menu_icon' => $menu->menu_icon,
                'menu_name' => $menu->menu_name,
            ];
            $groupedMenus[$menu->menu_name]['subs'][] = [
                'menu_sub_name' => $menu->menu_sub_name,
                'menu_sub_link' => $menu->menu_sub_link,
                'menu_sub_icon' => $menu->menu_sub_icon,
            ];
        }

        // dd($groupedMenus);
        return $groupedMenus;
    }


    public function getDataMasterInvoiceList()
    {
        $getData = DB::connection('mysql')->table('tbm_invoice_list')->where('deleted', 0)->orderBy('sort')->get();
        return $getData;
    }

    public function getDataAboutApp()
    {
        $getData = DB::connection('mysql')->table('tbm_about_app')->first();
        return $getData;
    }

    public function getEmployeeList()
    {
        $getEmployee = DB::connection('mysql')->table('tbt_employee')
            ->leftJoin('tbm_group', 'tbt_employee.map_company', '=', 'tbm_group.ID')
            ->leftJoin('tbm_department', 'tbm_group.department_id', '=', 'tbm_department.ID')
            ->leftJoin('tbm_company', 'tbm_department.company_id', '=', 'tbm_company.ID')
            ->leftJoin('tbm_class_list', 'tbt_employee.position_class', '=', 'tbm_class_list.ID')
            ->leftJoin('tbm_prefix_name', 'tbt_employee.prefix_id', '=', 'tbm_prefix_name.ID')
            ->leftJoin('tbm_province', 'tbt_employee.map_province', '=', 'tbm_province.ID')
            ->leftJoin('tbm_branch', 'tbt_employee.branch_id', '=', 'tbm_branch.id')
            ->where('tbt_employee.deleted', 0)
            ->where('tbt_employee.status_login', 1)
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
                'tbm_branch.branch_code'
            )->get();

        // dd($getEmployee);
        return $getEmployee;
    }

    public function getListCategoryMain($tag)
    {
        $getListCategoryMain = DB::connection('mysql')->table('tbm_category_main')->where('deleted', 0)->where('status_tag', 1)->where('use_tag', $tag)->orderBy('id')->get();
        return $getListCategoryMain;
    }

    public function getListCategoryType($categoryMainID)
    {
        $getListCategoryType = DB::connection('mysql')->table('tbm_category_type')->where('deleted', 0)->where('status_tag', 1)->where('category_main_id', $categoryMainID)->orderBy('id')->get();
        return $getListCategoryType;
    }

    public function getListCategoryDetail($categoryTypeID)
    {
        $getListCategoryDetail = DB::connection('mysql')->table('tbm_category_detail')->where('deleted', 0)->where('status_tag', 1)->where('category_type_id', $categoryTypeID)->orderBy('id')->get();
        return $getListCategoryDetail;
    }

    public function getListCategoryItem($categoryDetailID)
    {
        $getListCategoryItem = DB::connection('mysql')->table('tbm_category_item')->where('deleted', 0)->where('status_tag', 1)->where('category_detail_id', $categoryDetailID)->orderBy('id')->get();
        return $getListCategoryItem;
    }

    public function getListCategoryList($categoryItemID)
    {
        $getListCategoryList = DB::connection('mysql')->table('tbm_category_list')->where('deleted', 0)->where('status_tag', 1)->where('category_item_id', $categoryItemID)->orderBy('id')->get();
        // dd($getListCategoryList);
        return $getListCategoryList;
    }

    public function getChecker($tag)
    {
        $getChecker = DB::connection('mysql')->table('tbm_checker')->where('deleted', 0)->where('status_tag', 1)->whereIn('use_tag', [$tag, 'ALL'])->orderBy('id')->get();
        return $getChecker;
    }

    public function getEmployeeListByPosition($tagPosition)
    {
        $getEmployee = DB::connection('mysql')->table('tbt_employee')
            ->leftJoin('tbm_group', 'tbt_employee.map_company', '=', 'tbm_group.ID')
            ->leftJoin('tbm_department', 'tbm_group.department_id', '=', 'tbm_department.ID')
            ->leftJoin('tbm_company', 'tbm_department.company_id', '=', 'tbm_company.ID')
            ->leftJoin('tbm_class_list', 'tbt_employee.position_class', '=', 'tbm_class_list.ID')
            ->leftJoin('tbm_prefix_name', 'tbt_employee.prefix_id', '=', 'tbm_prefix_name.ID')
            ->leftJoin('tbm_province', 'tbt_employee.map_province', '=', 'tbm_province.ID')
            ->leftJoin('tbm_branch', 'tbt_employee.branch_id', '=', 'tbm_branch.id')
            ->where('tbt_employee.deleted', 0)
            ->where('tbt_employee.status_login', 1);
        if ($tagPosition == 'manager') {
            $getEmployee = $getEmployee->whereIn('tbt_employee.position_class', ['1', '3', '4']);
        } else if ($tagPosition == 'subManager') {
            $getEmployee = $getEmployee->whereNotIn('tbt_employee.position_class', ['1', '3', '4']);
        } else {
            $getEmployee = $getEmployee->whereNotNull('tbt_employee.position_class');
        }
        $getEmployee = $getEmployee->select(
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
            'tbm_branch.branch_code'
        )->get();

        // dd($getEmployee);
        return $getEmployee;
    }

    public function getDataAboutEmployee($empID)
    {
        try {
            $getEmployee = DB::connection('mysql')->table('tbt_employee')
                ->leftJoin('tbm_group', 'tbt_employee.map_company', '=', 'tbm_group.ID')
                ->leftJoin('tbm_department', 'tbm_group.department_id', '=', 'tbm_department.ID')
                ->leftJoin('tbm_company', 'tbm_department.company_id', '=', 'tbm_company.ID')
                ->leftJoin('tbm_class_list', 'tbt_employee.position_class', '=', 'tbm_class_list.ID')
                ->leftJoin('tbm_prefix_name', 'tbt_employee.prefix_id', '=', 'tbm_prefix_name.ID')
                ->leftJoin('tbm_province', 'tbt_employee.map_province', '=', 'tbm_province.ID')
                ->leftJoin('tbm_branch', 'tbt_employee.branch_id', '=', 'tbm_branch.id')
                ->where('tbt_employee.deleted', 0)
                ->where('tbt_employee.status_login', 1)
                ->where('tbt_employee.ID', $empID)
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
                    'tbm_branch.branch_code'
                )->first();

            // dd($getEmployee);
            return $getEmployee;
        } catch (Exception $e) {
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            return [
                'status' => intval($e->getCode()) ?: 500,
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function getBranchList()
    {
        $getBranch = DB::connection('mysql')->table('tbm_branch')->where('deleted', 0)->where('status_tag', 1)->orderBy('id')->get();
        return $getBranch;
    }

    public function getDataManager($empID)
    {
        try {
            $query = DB::connection('mysql')->table('tbt_sub_manager AS subManager')->where('subManager.sub_emp_id', $empID)->where('subManager.deleted', 0)
                ->leftJoin('tbt_manager AS manager', 'subManager.manager_id', '=', 'manager.id')
                ->leftJoin('tbt_employee AS Manageremployee', 'manager.manager_emp_id', '=', 'Manageremployee.ID')
                ->leftJoin('tbm_prefix_name', 'Manageremployee.prefix_id', '=', 'tbm_prefix_name.ID')
                ->leftJoin('tbt_employee AS SubManagerEmployee', 'subManager.sub_emp_id', '=', 'SubManagerEmployee.ID')
                ->leftJoin('tbm_prefix_name AS SubManagerPrefix', 'SubManagerEmployee.prefix_id', '=', 'SubManagerPrefix.ID')
                ->select('subManager.sub_emp_id', 'manager.manager_emp_id', DB::raw('CONCAT(tbm_prefix_name.prefix_name, " ", Manageremployee.first_name, " ", Manageremployee.last_name) AS full_name_manager'), DB::raw('CONCAT(SubManagerPrefix.prefix_name, " ", SubManagerEmployee.first_name, " ", SubManagerEmployee.last_name) AS full_name_sub_manager'))
                ->first();
            return $query;
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

    public function getDataCategoryMain($useTag)
    {
        $query = DB::connection('mysql')->table('tbm_category_main')->where('deleted', 0)->where('status_tag', 1)->where('use_tag', $useTag)->orderBy('id')->get();
        return $query;
    }

    public function checkAccessManager($empID)
    {
        try {
            $query = DB::connection('mysql')->table('tbt_manager AS manager')
                ->leftJoin('tbt_sub_manager AS subManager', 'manager.id', '=', 'subManager.manager_id')
                ->where('manager.manager_emp_id', $empID)
                ->where('manager.deleted', 0)->get();
            // dd($query);
            return $query;
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

    public function getFullNameEmp($mapEmployee, $tag)
    {
        $query = DB::connection('mysql')
            ->table('tbt_employee AS empUser')
            ->leftJoin('tbm_prefix_name AS preUser', 'empUser.prefix_id', '=', 'preUser.ID');
        if ($tag == 'mapEmpID') {
            $query =  $query->where('empUser.ID', $mapEmployee);
        } else if ($tag = 'mapEmpCode') {
            $query =  $query->where('empUser.employee_code', $mapEmployee);
        }
        $query = $query->where('empUser.deleted', 0)
            ->select(DB::raw("CONCAT(preUser.prefix_name,' ',empUser.first_name,' ',empUser.last_name) as employee_name"))
            ->first();
        return $query->employee_name;
    }

    public function getDataWorker()
    {
        try {
            $query = DB::connection('mysql')->table('tbt_employee AS employee')
                ->leftJoin('tbm_prefix_name', 'employee.prefix_id', '=', 'tbm_prefix_name.ID')
                ->where('employee.deleted', 0)
                ->select(
                    DB::raw("CONCAT(tbm_prefix_name.prefix_name,' ',employee.first_name,' ',employee.last_name) as employee_name"),
                    'employee.ID',
                    'employee.employee_code',
                    'employee.img_base',
                )
                ->get();
            return $query;
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

    public function getDataStatusWork($useTag)
    {
        $query = DB::connection('mysql')->table('tbm_status_work')->where('deleted', 0)->where('status', 1)
        ->whereIn('status_use', ['all', $useTag])->orderBy('id')->get();
        return $query;
    }
}
