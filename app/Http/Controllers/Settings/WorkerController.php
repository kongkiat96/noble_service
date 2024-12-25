<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use App\Models\Master\getDataMasterModel;
use App\Models\Settings\WorkerModel;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    private $masterModel;
    private $workerModel;

    public function __construct()
    {
        $this->masterModel = new getDataMasterModel();
        $this->workerModel = new WorkerModel();
    }
    public function index()
    {
        $url = request()->segments();
        $urlName = "กำหนดรายการผู้ปฏิบัติงาน";
        $urlSubLink = "worker";

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.settings.worker.index', [
            'url' => $url,
            'urlName' => $urlName, 
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }

    public function getDataWorker(Request $request)
    {
        // dd($request);
        $getData = $this->workerModel->getDataWorker($request);
        return response()->json($getData);
    }

    public function showAddWorkerModal()
    {
        if (request()->ajax()) {
            $getDataEmployee = $this->masterModel->getEmployeeListByPosition('all');

            return view('app.settings.worker.dialog.save.addWorker', [
                'getDataEmployee' => $getDataEmployee
            ]);
        }
        return abort(404);
    }

    public function saveDataWorker(Request $request)
    {
        $saveData = $this->workerModel->saveDataWorker($request->input());
        // dd($saveData);
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function showEditWorker($workerID)
    {
        if (request()->ajax()) {
            $getDataEmployee = $this->masterModel->getEmployeeListByPosition('all');
            $getDataWorker = $this->workerModel->getDataWorkerByID($workerID);
            $getDataOnSelect = $this->masterModel->getDataAboutEmployee($getDataWorker->employee_id);

            return view('app.settings.worker.dialog.edit.editWorker', [
                'getDataEmployee' => $getDataEmployee,
                'getDataWorker' => $getDataWorker,
                'getDataOnSelect' => $getDataOnSelect
            ]);
        }
        return abort(404);
    }
}
