<?php

namespace App\Http\Controllers\Employee;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use App\Models\Employee\ManagerModel;
use App\Models\Master\getDataMasterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ManagerController extends Controller
{
    private $masterModel;
    private $managerModel;

    public function __construct()
    {
        $this->masterModel = new getDataMasterModel();
        $this->managerModel = new ManagerModel();
    }
    public function index()
    {
        $url = request()->segments();
        $urlName = "กำหนดรายการผู้บังคับบัญชา";
        $urlSubLink = "manager";

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        $getDataManager = $this->masterModel->getEmployeeListByPosition('manager');
        $getDataSubManager = $this->masterModel->getEmployeeListByPosition('subManager');
        return view('app.employee.manager.index', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus,
            'dataManager' => $getDataManager,
            'dataSubManager' => $getDataSubManager
        ]);
    }

    public function index_sub_manager($managerID)
    {
        // dd($managerID);
        $managerID = Crypt::decrypt($managerID);
        $url = request()->segments();
        $urlName = "กำหนดรายการผู้ใต้บังคับบัญชา";
        $urlSubLink = "manager";
        $getDataManager = $this->managerModel->getDataManagerByID($managerID,'manager');
        $getDataDetailManager = $this->masterModel->getDataAboutEmployee($getDataManager->manager_emp_id);

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();
        // dd($managerID);
        return view('app.employee.manager.indexSubManager', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus,
            'getDataManager' => $getDataDetailManager,
            'managerID' => $managerID
        ]);
    }

    public function showAddManagerModal()
    {
        if (request()->ajax()) {
            $getDataEmployee = $this->masterModel->getEmployeeListByPosition('manager');
            // dd($getDataEmployee);
            return view('app.employee.manager.dialog.save.addManager', [
                'getDataEmployee' => $getDataEmployee
            ]);
        }

        return abort(404);
    }

    public function showAddSubManagerModal($managerID)
    {
        $getDataEmployee = $this->masterModel->getEmployeeListByPosition('subManager');
        $getDataManager = $this->managerModel->getDataManagerByID($managerID,'manager');
        // dd($getDataManager);
        return view('app.employee.manager.dialog.save.addSubManager', [
            'getDataEmployee' => $getDataEmployee,
            'managerID' => $managerID,
            'dataManager' => $getDataManager
        ]);
    }

    public function saveDataManager(Request $request)
    {
        $saveData = $this->managerModel->saveDataManager($request->input());
        // dd($saveData);
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function saveDataSubManager(Request $request)
    {
        $saveData = $this->managerModel->saveDataSubManager($request->input());
        // dd($saveData);
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function getDataManager(Request $request)
    {
        $getData = $this->managerModel->getDataManager($request);
        return response()->json($getData);
    }

    public function getDataSubManager(Request $request)
    {
        $getData = $this->managerModel->getDataSubManager($request);
        return response()->json($getData);
    }

    public function showEditManager($managerID)
    {
        // dd($managerID);
        if (request()->ajax()) {
            $getDataManager = $this->managerModel->getDataManagerByID($managerID,'manager');

            $getDataEmployee = $this->masterModel->getEmployeeListByPosition('manager');
            $getDataOnSelect = $this->masterModel->getDataAboutEmployee($getDataManager->manager_emp_id);

            // dd($getDataOnSelect);
            return view('app.employee.manager.dialog.edit.editManager', [
                'dataManager' => $getDataManager,
                'getDataEmployee'   => $getDataEmployee,
                'getDataOnSelect'   => $getDataOnSelect,
            ]);
        }
        return abort(404);
    }

    public function showEditSubManager($subManagerID)
    {
        // dd($subManagerID);
        if (request()->ajax()) {
            $getDataManager = $this->managerModel->getDataManagerByID($subManagerID,'subManager');
            // dd($getDataManager);
            $getDataManagerCheck = $this->managerModel->getDataManagerByID($getDataManager->manager_id,'manager');
            $getDataEmployee = $this->masterModel->getEmployeeListByPosition('subManager');
            $getDataOnSelect = $this->masterModel->getDataAboutEmployee($getDataManager->sub_emp_id);
            // dd($getDataOnSelect);
            return view('app.employee.manager.dialog.edit.editSubManager', [
                'dataManager' => $getDataManager,
                'getDataEmployee'   => $getDataEmployee,
                'getDataOnSelect'   => $getDataOnSelect,
                'dataManagerCheck' => $getDataManagerCheck
            ]);
        }
        return abort(404);
    }

    public function saveEditManager(Request $request, $managerID)
    {
        $saveData = $this->managerModel->saveEditManager($request->input(), $managerID);
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function saveEditSubManager(Request $request, $subManagerID)
    {
        $saveData = $this->managerModel->saveEditSubManager($request->input(), $subManagerID);
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function deleteManager($managerID)
    {
        $deleteData = $this->managerModel->deleteManager($managerID,'manager');
        return response()->json(['status' => $deleteData['status'], 'message' => $deleteData['message']]);
    }

    public function deleteSubManager($subManagerID)
    {
        $deleteData = $this->managerModel->deleteManager($subManagerID, 'subManager');
        return response()->json(['status' => $deleteData['status'], 'message' => $deleteData['message']]);
    }

    public function getDataSearchManager(Request $request)
    {
        if(empty($request['manager_id']) && empty($request['sub_emp_id'])){
            $getData = [
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
            ];
            return response()->json($getData);
        } else {
            $getData = $this->managerModel->getDataSearchManager($request);
            return response()->json($getData);
        }
        
    }
}
