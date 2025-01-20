<?php

namespace App\Http\Controllers;

use App\Helpers\CalculateDateHelper;
use App\Models\Employee\EmployeeModel;
use App\Models\Master\getDataMasterModel;
use App\Models\Service\ApproveCaseModel;
use Illuminate\Http\Request;
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
        // dd($getDataEmployee);
        $getDepartment  = $this->masterModel->getDataCompanyForID($getDataEmployee->department_id);
        // dd($getDepartment);
        $getCalWorking = CalculateDateHelper::convertDateAndCalculateServicePeriod($getDataEmployee->date_start_work);
        $getDataSelectEmp = $this->masterModel->getEmployeeListByPosition('all');
        // dd(Auth::user()->map_employee);
        $getDataManager = $this->masterModel->getDataManager(Auth::user()->map_employee);
        $checkAccessManaget = $this->masterModel->checkAccessManager(Auth::user()->map_employee);
        $countCaseApprove = $this->approveCaseModel->countCaseApprove(Auth::user()->map_employee);
        // dd($countCaseApprove);
        // dd(COUNT($checkAccessManaget));
        // dd($getCalWorking);
        return view('app.home.index', [
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

    public function myProfile()
    {
        $user = Auth::user();
        $url = request()->segments();
        $urlName = "ข้อมูลส่วนตัว";
        $accessMenuSubIDs = $user->accessMenus->pluck('menu_sub_ID')->toArray();
        $getAccessMenus = getDataMasterModel::getMenusName($accessMenuSubIDs);
        $getDataEmployee = $this->employeeModel->getDataEmployee(Auth::user()->map_employee);
        // dd($getDataEmployee);
        $getDepartment  = $this->masterModel->getDataCompanyForID($getDataEmployee->department_id);
        // $dataManager = response()->json($this->testManager());
        $dataManager = $this->testManager();
        return view('app.home.myProfile', [
            'name'      => $user->name,
            'urlName'   => $urlName,
            'url'       => $url,
            'dataEmployee'      => $getDataEmployee,
            'aboutDepartment'   => $getDepartment,
            'listMenus'         => $getAccessMenus,
            'dataManager'   => $dataManager
        ]);
    }

    public function changePassword(Request $request)
    {
        dd($request->input());
    }
    private function testManager()
    {
        $dataJson = [
            [
                "id" => 1,
                "EmployeeName" => "Manager A",
                "Title" => "Manager",
                "pid" => null,
                "ImgUrl" => "https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png",
                "subordinates" => [
                    [
                        "id" => 3,
                        "EmployeeName" => "Employee A1",
                        "Title" => "Manager",
                        "pid" => 1,
                        "subordinates" => [],
                        "ImgUrl" => "https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png",
                    ],
                    [
                        "id" => 4,
                        "EmployeeName" => "Employee A2",
                        "Title" => "Manager",
                        "pid" => 1,
                        "subordinates" => [],
                        "ImgUrl" => "https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png",
                    ],
                    [
                        "id" => 5,
                        "EmployeeName" => "Employee A2",
                        "Title" => "Manager",
                        "pid" => 1,
                        "subordinates" => [],
                        "ImgUrl" => "https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png",
                    ],
                    [
                        "id" => 6,
                        "EmployeeName" => "Employee A2",
                        "Title" => "Manager",
                        "pid" => 1,
                        "subordinates" => [],
                        "ImgUrl" => "https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png",
                    ]
                ]
            ],
        ];

        return $dataJson; // ส่งข้อมูลกลับในรูปแบบ Array
    }
}
