<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use App\Models\Master\getDataMasterModel;
use App\Models\Settings\CaseApproveSpecialModel;
use Illuminate\Http\Request;

class CaseApproveSpecialController extends Controller
{
    private $getMaster;
    private $caseApproveSpecialModel;
    public function __construct()
    {
        $this->getMaster = new getDataMasterModel();
        $this->caseApproveSpecialModel = new CaseApproveSpecialModel();
    }
    public function index()
    {
        $url = request()->segments();
        $urlSubLink = "case-approve-special";
        $getMenuName = $this->getMaster->searchMenuName($urlSubLink);
        $urlName = $getMenuName->menu_sub_name;

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.settings.caseApproveSpecial.index', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }

    public function getDataCaseApproveSpecial(Request $request)
    {
        $getDataCaseApprove = $this->caseApproveSpecialModel->getDataCaseApproveSpecial($request);
        return response()->json($getDataCaseApprove);
    }

    public function showAddCaseCCTVModal()
    {
        if (request()->ajax()) {
            // $getDataEmployee = $this->masterModel->getEmployeeListByPosition('all');
            $getListCategoryMain = $this->getMaster->getDataCategoryMain('IT');
            $getListCategoryType = $this->getMaster->getListCategoryType('IT');
            $getListCategoryDetail = $this->getMaster->getListCategoryDetail('IT');

            return view('app.settings.caseApproveSpecial.dialog.save.addCaseCCTV', [
                'dataCategoryMain' => $getListCategoryMain,
                'dataCategoryType' => $getListCategoryType,
                'dataCategoryDetail' => $getListCategoryDetail
            ]);
        }
        return abort(404);
    }

    public function showAddCasePermissionModal()
    {
        if (request()->ajax()) {
            // $getDataEmployee = $this->masterModel->getEmployeeListByPosition('all');
            $getListCategoryMain = $this->getMaster->getDataCategoryMain('IT');
            $getListCategoryType = $this->getMaster->getListCategoryType('IT');
            $getListCategoryDetail = $this->getMaster->getListCategoryDetail('IT');

            return view('app.settings.caseApproveSpecial.dialog.save.addCasePermission', [
                'dataCategoryMain' => $getListCategoryMain,
                'dataCategoryType' => $getListCategoryType,
                'dataCategoryDetail' => $getListCategoryDetail
            ]);
        }
        return abort(404);
    }

    public function showEditCaseApprove($caseApproveID)
    {
        if (request()->ajax()) {
            $getDataCaseApprove = $this->caseApproveSpecialModel->getCaseApproveSpecialByID($caseApproveID);
            // dd($getDataCaseApprove);
            $getListCategoryMain = $this->getMaster->getDataCategoryMain($getDataCaseApprove->tag);
            $getListCategoryType = $this->getMaster->getListCategoryType($getDataCaseApprove->category_main);
            $getListCategoryDetail = $this->getMaster->getListCategoryDetail($getDataCaseApprove->category_type);
            switch ($getDataCaseApprove->use_tag) {
                case 'cctv':
                    $setTitle = 'แจ้งขอตรวจสอบ CCTV';
                    break;
                case 'permission':
                    $setTitle = 'แจ้งขอสิทธิ์ใช้งาน';
                    break;
                default:
                    $setTitle = 'Unknown';
                    break;
            }
            return view('app.settings.caseApproveSpecial.dialog.edit.editCaseApprove', [
                'dataCaseApprove' => $getDataCaseApprove,
                'dataCategoryMain' => $getListCategoryMain,
                'dataCategoryType' => $getListCategoryType,
                'dataCategoryDetail' => $getListCategoryDetail,
                'setTitle' => $setTitle
            ]);
        }
        return abort(404);
    }

    public function saveCaseCCTVData(Request $request)
    {
        $saveData = $this->caseApproveSpecialModel->saveCaseCCTVData($request->input());
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function saveCasePermissionData(Request $request)
    {
        $setInput = [
            'category_main' => $request->input('category_main_per'),
            'category_type' => $request->input('category_type_per'),
            'category_detail' => $request->input('category_detail_per'),
            'status_use'    => $request->input('status_use')
        ];
        $saveData = $this->caseApproveSpecialModel->saveCasePermissionData($setInput);
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function saveEditCaseApprove($caseApproveID, Request $request)
    {
        $caseApproveID = decrypt($caseApproveID);
        // dd($request->input());
        $setInput = [
            'category_main' => $request->input('category_main_edit'),
            'category_type' => $request->input('category_type_edit'),
            'category_detail' => $request->input('category_detail_edit'),
            'status_use'    => $request->input('status_use')
        ];
        $saveData = $this->caseApproveSpecialModel->saveEditCaseApprove($caseApproveID, $setInput);
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function deleteCaseApprove($caseApproveID)
    {
        $deleteData = $this->caseApproveSpecialModel->deleteCaseApprove($caseApproveID);
        return response()->json(['status' => $deleteData['status'], 'message' => $deleteData['message']]);
    }
}
