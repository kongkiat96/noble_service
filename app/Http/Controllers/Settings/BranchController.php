<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use App\Models\Settings\BranchModel;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    private $setBranchModel;

    public function __construct()
    {
        $this->setBranchModel = new BranchModel();   
    }
    public function index()
    {
        $url = request()->segments();
        $urlName = "กำหนดรายการสาขา (Branch)";
        $urlSubLink = "branch";

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.settings.branch.index', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }

    public function showAddBranchModal() {
        if(request()->ajax()) {
            return view('app.settings.branch.dialog.save.addBranch');
        }
        return abort(404);
    }

    public function saveBranchData(Request $request)
    {
        $dataBranch = $this->setBranchModel->saveBranchData($request->input());
        return response()->json(['status' => $dataBranch['status'], 'message' => $dataBranch['message']]);
    }

    public function getDataBranch(Request $request)
    {
        $getData = $this->setBranchModel->getDataBranch($request);
        return response()->json($getData);
    }

    public function showEditBranch($branchID) 
    {
        if(request()->ajax()) {
            $getDataBranch = $this->setBranchModel->getDataBranchByID($branchID);
            return view('app.settings.branch.dialog.edit.editBranch', ['getDataBranch' => $getDataBranch]);
        }
        return abort(404);
    }

    public function saveEditBranch(Request $request, $branchID) {
        $dataBranch = $this->setBranchModel->saveEditBranchData($request->input(), $branchID);
        return response()->json(['status' => $dataBranch['status'], 'message' => $dataBranch['message']]);
    }

    public function deleteBranch($branchID) {
        $dataBranch = $this->setBranchModel->deleteBranchData($branchID);
        return response()->json(['status' => $dataBranch['status'], 'message' => $dataBranch['message']]);
    }
}
