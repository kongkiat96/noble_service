<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use App\Models\Settings\CheckerModel;
use Illuminate\Http\Request;

class CheckerController extends Controller
{
    private $setCheckerModel;
    public function __construct()
    {
        $this->setCheckerModel = new CheckerModel();
    }   
    public function index()
    {
        $url = request()->segments();
        $urlName = "กำหนดรายการผู้ตรวจเช็ค/ซ่อม";
        $urlSubLink = "checker";

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.settings.checker.index', [
            'url' => $url,
            'urlName' => $urlName, 
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }

    public function showAddCheckerModal()
    {
        if (request()->ajax()) {
            return view('app.settings.checker.dialog.save.addChecker', [
            ]);
        }
        return abort(404);
    }

    public function getDataChecker(Request $request)
    {
        $getData = $this->setCheckerModel->getDataChecker($request);
        return response()->json($getData);
    }

    public function saveCheckerData(Request $request)
    {
        $dataChecker = $this->setCheckerModel->saveDataChecker($request->input());
        return response()->json(['status' => $dataChecker['status'], 'message' => $dataChecker['message']]);
    }

    public function showEditChecker($checkerID)
    {
        if (request()->ajax()) {
            $getData = $this->setCheckerModel->getDataCheckerByID($checkerID);
            return view('app.settings.checker.dialog.edit.editChecker', [
                'dataChecker' => $getData
            ]);
        }
        return abort(404);
    }

    public function saveEditChecker($checkerID, Request $request)
    {
        $dataChecker = $this->setCheckerModel->editDataChecker($checkerID, $request->input());
        return response()->json(['status' => $dataChecker['status'], 'message' => $dataChecker['message']]);
    }

    public function deleteChecker($checkerID)
    {
        $dataChecker = $this->setCheckerModel->deleteDataChecker($checkerID);
        return response()->json(['status' => $dataChecker['status'], 'message' => $dataChecker['message']]);
    }
}
