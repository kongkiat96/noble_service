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

        return view('app.employee.manager.index', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }

    public function index_sub_manager($managerID)
    {
        // dd($managerID);
        $managerID = Crypt::decrypt($managerID);
        $url = request()->segments();
        $urlName = "กำหนดรายการผู้ใต้บังคับบัญชา";
        $urlSubLink = "manager";
        $getDataManager = $this->managerModel->getDataManagerByID($managerID);
        $getDataDetailManager = $this->masterModel->getDataAboutEmployee($getDataManager->manager_emp_id);

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.employee.manager.indexSubManager', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus,
            'getDataManager' => $getDataDetailManager,
        ]);
    }

    public function showAddManagerModal()
    {
        if (request()->ajax()) {
            $getDataEmployee = $this->masterModel->getEmployeeListByPosition();
            // dd($getDataEmployee);
            return view('app.employee.manager.dialog.save.addManager', [
                'getDataEmployee' => $getDataEmployee
            ]);
        }

        return abort(404);
    }

    public function saveDataManager(Request $request)
    {
        $saveData = $this->managerModel->saveDataManager($request->input());
        // dd($saveData);
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function getDataManager(Request $request)
    {
        $getData = $this->managerModel->getDataManager($request);
        return response()->json($getData);
    }

    public function showEditManager($managerID)
    {
        // dd($managerID);
        if (request()->ajax()) {
            $getDataManager = $this->managerModel->getDataManagerByID($managerID);

            $getDataEmployee = $this->masterModel->getEmployeeListByPosition();
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

    public function saveEditManager(Request $request, $managerID)
    {
        $saveData = $this->managerModel->saveEditManager($request->input(), $managerID);
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function deleteManager($managerID)
    {
        $deleteData = $this->managerModel->deleteManager($managerID);
        return response()->json(['status' => $deleteData['status'], 'message' => $deleteData['message']]);
    }
}
