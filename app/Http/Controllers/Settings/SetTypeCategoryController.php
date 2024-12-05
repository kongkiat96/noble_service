<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use App\Models\Master\getDataMasterModel;
use App\Models\Settings\SetTypeCategoryModel;
use Illuminate\Http\Request;

class SetTypeCategoryController extends Controller
{
    private $setCategoryModel;
    private $masterModel;

    public function __construct()
    {
        $this->setCategoryModel = new SetTypeCategoryModel();
        $this->masterModel = new getDataMasterModel();
    }
    public function index_it()
    {
        $url = request()->segments();
        $urlName = "กำหนดรายการประเภทแจ้งซ่อม (ITs)";
        $urlSubLink = "set-type-category-it";

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.settings.setTypeCategory.its.index', [
            'url' => $url,
            'urlName' => $urlName, 
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }

    public function showAddCategoryMainModal(){
        if (request()->ajax()) {
            return view('app.settings.setTypeCategory.its.dialog.save.addCategoryMain', [
            ]);
        }
        return abort(404);
    }

    public function showAddCategoryTypeModal()
    {
        if (request()->ajax()) {
            $getListCategoryMain = $this->setCategoryModel->getListCategoryMain();
            return view('app.settings.setTypeCategory.its.dialog.save.addCategoryType', [
            ]);
        }
        return abort(404);
    }

    public function saveCategory(Request $request)
    {
        $dataCategory = $this->setCategoryModel->saveDataCategoryMain($request->input());
        return response()->json(['status' => $dataCategory['status'], 'message' => $dataCategory['message']]);
    }

    public function showEditCategoryMain($categoryID){
        if (request()->ajax()) {
            $getDataCategoryMain = $this->setCategoryModel->getDataCategoryMainByID($categoryID);

            // dd($getDataCategoryMain);
            return view('app.settings.setTypeCategory.its.dialog.edit.editCategoryMain', [
                'dataCategoryMain' => $getDataCategoryMain,
            ]);
        }
        return abort(404);
    }

    public function getDataCategoryMain(Request $request){
        $getData = $this->setCategoryModel->getDataCategoryMain($request);
        return response()->json($getData);
    }

    public function editCategoryMain($categoryID, Request $request){
        $dataCategory = $this->setCategoryModel->saveEditDataCategoryMain($categoryID, $request->input());
        return response()->json(['status' => $dataCategory['status'], 'message' => $dataCategory['message']]);
    }

    public function deleteCategoryMain($categoryID){
        // dd($categoryID);
        $dataCategory = $this->setCategoryModel->deleteDataCategoryMain($categoryID);
        return response()->json(['status' => $dataCategory['status'], 'message' => $dataCategory['message']]);
    }
}
