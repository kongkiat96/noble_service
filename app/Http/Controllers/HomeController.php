<?php

namespace App\Http\Controllers;

use App\Helpers\CalculateDateHelper;
use App\Models\Employee\EmployeeModel;
use App\Models\Master\getDataMasterModel;
use App\Models\Service\ApproveCaseModel;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private $employeeModel;
    private $masterModel;
    private $approveCaseModel;
    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
        $this->masterModel = new getDataMasterModel;
        $this->approveCaseModel = new ApproveCaseModel();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $url = request()->segments();
        $urlName = "ข้อมูลผู้ใช้งาน";
        $accessMenuSubIDs = $user->accessMenus->pluck('menu_sub_ID')->toArray();
        $getAccessMenus = getDataMasterModel::getMenusName($accessMenuSubIDs);
        // dd(Auth::user()->map_employee);
        $prefixName     = $this->masterModel->getDataPrefixName();
        $provinceName   = $this->masterModel->getDataProvince();
        $getCompany     = $this->masterModel->getDataCompany();
        $getClassList   = $this->masterModel->getClassList();
        $getDataEmployee = $this->employeeModel->getDataEmployee(Auth::user()->map_employee);
        $getDepartment  = $this->masterModel->getDataCompanyForID($getDataEmployee->department_id);
        // dd($getDataEmployee);
        $getCalWorking = CalculateDateHelper::convertDateAndCalculateServicePeriod($getDataEmployee->date_start_work);
        $getDataSelectEmp = $this->masterModel->getEmployeeListByPosition('all');
        // dd(Auth::user()->map_employee);
        $getDataManager = $this->masterModel->getDataManager(Auth::user()->map_employee);
        $checkAccessManaget = $this->masterModel->checkAccessManager(Auth::user()->map_employee);
        $countCaseApprove = $this->approveCaseModel->countCaseApprove(Auth::user()->map_employee);
        // dd($countCaseApprove);
        // dd(COUNT($checkAccessManaget));
        // dd($getCalWorking);
        return view('app.home.index',[
            'name'      => $user->name,
            'urlName'   => $urlName,
            'url'       => $url,
            'dataEmployee'      => $getDataEmployee,
            'listMenus'         => $getAccessMenus,
            'getCalWorking'     => $getCalWorking,
            'aboutDepartment'   => $getDepartment,
            'dataAllEmployee'   => $getDataSelectEmp,
            'dataManager'       => $getDataManager,
            'checkAccessManaget' => $checkAccessManaget,
            'countCaseApprove' => $countCaseApprove
        ]);
    }
}
