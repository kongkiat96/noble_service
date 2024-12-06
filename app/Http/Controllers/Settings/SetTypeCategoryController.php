<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use App\Models\Master\getDataMasterModel;
use App\Models\Settings\SetTypeCategoryModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

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

    public function index_mt()
    {
        $url = request()->segments();
        $urlName = "กำหนดรายการประเภทแจ้งซ่อม (MTs)";
        $urlSubLink = "set-type-category-mt";

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.settings.setTypeCategory.mts.index', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }

    public function showAddCategoryMainModal()
    {
        if (request()->ajax()) {
            return view('app.settings.setTypeCategory.its.dialog.save.addCategoryMain', []);
        }
        return abort(404);
    }

    public function showAddCategoryTypeModal()
    {
        if (request()->ajax()) {
            $getListCategoryMain = $this->masterModel->getListCategoryMain('IT');
            // dd($getListCategoryMain);
            return view('app.settings.setTypeCategory.its.dialog.save.addCategoryType', [
                'dataCategoryMain' => $getListCategoryMain
            ]);
        }
        return abort(404);
    }

    public function showAddCategoryDetailModal()
    {
        if (request()->ajax()) {
            $getListCategoryMain = $this->masterModel->getListCategoryMain('IT');
            // dd($getListCategoryMain);
            return view('app.settings.setTypeCategory.its.dialog.save.addCategoryDetail', [
                'dataCategoryMain' => $getListCategoryMain
            ]);
        }
        return abort(404);
    }

    public function showAddCategoryMainModal_mt()
    {
        if (request()->ajax()) {
            return view('app.settings.setTypeCategory.mts.dialog.save.addCategoryMain', []);
        }
        return abort(404);
    }

    public function showAddCategoryTypeModal_mt()
    {
        if (request()->ajax()) {
            $getListCategoryMain = $this->masterModel->getListCategoryMain('MT');
            // dd($getListCategoryMain);
            return view('app.settings.setTypeCategory.mts.dialog.save.addCategoryType', [
                'dataCategoryMain' => $getListCategoryMain
            ]);
        }
        return abort(404);
    }

    public function showAddCategoryDetailModal_mt()
    {
        if (request()->ajax()) {
            $getListCategoryMain = $this->masterModel->getListCategoryMain('MT');
            // dd($getListCategoryMain);
            return view('app.settings.setTypeCategory.mts.dialog.save.addCategoryDetail', [
                'dataCategoryMain' => $getListCategoryMain
            ]);
        }
        return abort(404);
    }

    public function saveCategoryMain(Request $request)
    {
        $dataCategory = $this->setCategoryModel->saveDataCategoryMain($request->input());
        return response()->json(['status' => $dataCategory['status'], 'message' => $dataCategory['message']]);
    }

    public function saveCategoryType(Request $request)
    {
        $dataCategory = $this->setCategoryModel->saveDataCategoryType($request->input());
        return response()->json(['status' => $dataCategory['status'], 'message' => $dataCategory['message']]);
    }

    public function saveCategoryDetail(Request $request)
    {
        $dataCategory = $this->setCategoryModel->saveDataCategoryDetail($request->input());
        return response()->json(['status' => $dataCategory['status'], 'message' => $dataCategory['message']]);
    }

    public function showEditCategoryMain($categoryMainID)
    {
        if (request()->ajax()) {
            $getDataCategoryMain = $this->setCategoryModel->getDataCategoryMainByID($categoryMainID);

            // dd($getDataCategoryMain);
            return view('app.settings.setTypeCategory.its.dialog.edit.editCategoryMain', [
                'dataCategoryMain' => $getDataCategoryMain,
            ]);
        }
        return abort(404);
    }

    public function showEditCategoryType($categoryTypeID)
    {
        if (request()->ajax()) {
            $getDataCategoryType = $this->setCategoryModel->getDataCategoryTypeByID($categoryTypeID);
            $getListCategoryMain = $this->masterModel->getListCategoryMain($getDataCategoryType->use_tag);
            // dd($getListCategoryMain);
            return view('app.settings.setTypeCategory.its.dialog.edit.editCategoryType', [
                'dataCategoryType' => $getDataCategoryType,
                'dataCategoryMain' => $getListCategoryMain
            ]);
        }
        return abort(404);
    }

    public function showEditCategoryDetail($categoryDetailID)
    {
        if (request()->ajax()) {
            $getDataCategoryDetail = $this->setCategoryModel->getDataCategoryDetailByID($categoryDetailID);
            $getListCategoryMain = $this->masterModel->getListCategoryMain($getDataCategoryDetail->use_tag);
            $getListCategoryType = $this->masterModel->getListCategoryType($getDataCategoryDetail->category_main_id);
            // dd($getListCategoryMain);
            return view('app.settings.setTypeCategory.its.dialog.edit.editCategoryDetail', [
                'dataCategoryDetail' => $getDataCategoryDetail,
                'dataCategoryMain' => $getListCategoryMain,
                'dataCategoryType' => $getListCategoryType
            ]);
        }
        return abort(404);
    }

    public function getDataCategoryMain(Request $request)
    {
        $getData = $this->setCategoryModel->getDataCategoryMain($request);
        return response()->json($getData);
    }

    public function getDataCategoryType(Request $request)
    {
        $getData = $this->setCategoryModel->getDataCategoryType($request);
        return response()->json($getData);
    }

    public function getDataCategoryDetail(Request $request)
    {
        $getData = $this->setCategoryModel->getDataCategoryDetail($request);
        return response()->json($getData);
    }

    public function editCategoryMain($categoryMainID, Request $request)
    {
        $dataCategory = $this->setCategoryModel->saveEditDataCategoryMain($categoryMainID, $request->input());
        return response()->json(['status' => $dataCategory['status'], 'message' => $dataCategory['message']]);
    }

    public function editCategoryType($categoryTypeID, Request $request)
    {
        $dataCategory = $this->setCategoryModel->saveEditDataCategoryType($categoryTypeID, $request->input());
        return response()->json(['status' => $dataCategory['status'], 'message' => $dataCategory['message']]);
    }

    public function editCategoryDetail($categoryDetailID, Request $request)
    {
        $dataCategory = $this->setCategoryModel->saveEditDataCategoryDetail($categoryDetailID, $request->input());
        return response()->json(['status' => $dataCategory['status'], 'message' => $dataCategory['message']]);
    }

    public function deleteCategoryMain($categoryMainID)
    {
        // dd($categoryMainID);
        $dataCategory = $this->setCategoryModel->deleteDataCategoryMain($categoryMainID);
        return response()->json(['status' => $dataCategory['status'], 'message' => $dataCategory['message']]);
    }

    public function deleteCategoryType($categoryTypeID)
    {
        // dd($categoryMainID);
        $dataCategory = $this->setCategoryModel->deleteDataCategoryType($categoryTypeID);
        return response()->json(['status' => $dataCategory['status'], 'message' => $dataCategory['message']]);
    }

    public function deleteCategoryDetail($categoryDetailID)
    {
        // dd($categoryMainID);
        $dataCategory = $this->setCategoryModel->deleteDataCategoryDetail($categoryDetailID);
        return response()->json(['status' => $dataCategory['status'], 'message' => $dataCategory['message']]);
    }

    public function setDetailCategory($encryptID)
    {
        try {
            $decryptID = Crypt::decrypt($encryptID);
            // dd($decryptID);
            $dataCategory = $this->setCategoryModel->getDataCategoryDetailAllByID($decryptID);
            // dd($dataCategory);
            $url = request()->segments();
            $urlName = "กำหนดรายรายละเอียดสำหรับเจ้าหน้าที่ (" . $dataCategory->use_tag . "s)";
            $urlSubLink = "set-type-category-". strtolower($dataCategory->use_tag);

            if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
                return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
            }
            $getAccessMenus = getAccessToMenu::getAccessMenus();
            return view('app.settings.setTypeCategory.setDetail.index', [
                'dataCategoryDetail' => $dataCategory,
                'url' => $url,
                'urlName' => $urlName,
                'urlSubLink' => $urlSubLink,
                'listMenus' => $getAccessMenus,
                'tag' => $dataCategory->use_tag
            ]);
        } catch (Exception $e) {
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
        }
    }

    public function showAddCategoryItemModal($categoryDetailID)
    {
        if (request()->ajax()) {
            return view('app.settings.setTypeCategory.setDetail.dialog.save.addCategoryItem', [
                'categoryDetailID' => $categoryDetailID
            ]);
        }
        return abort(404);
    }

    public function saveCategoryItem(Request $request)
    {
        $dataCategory = $this->setCategoryModel->saveCategoryItem($request->input());
        return response()->json(['status' => $dataCategory['status'], 'message' => $dataCategory['message']]);
    }

    public function getDataCategoryItem(Request $request)
    {
        // dd($request);
        $getData = $this->setCategoryModel->getDataCategoryItem($request);
        return response()->json($getData);
    }

    public function showEditCategoryItem($categoryItemID)
    {
        if (request()->ajax()) {
            $getDataCategoryItem = $this->setCategoryModel->getDataCategoryItemByID($categoryItemID);
            // dd($getDataCategoryItem);
            return view('app.settings.setTypeCategory.setDetail.dialog.edit.editCategoryItem', [
                'dataCategoryItem' => $getDataCategoryItem
            ]);
        }
        return abort(404);
    }

    public function editCategoryItem($categoryItemID, Request $request)
    {
        $dataCategory = $this->setCategoryModel->saveEditDataCategoryItem($categoryItemID, $request->input());
        return response()->json(['status' => $dataCategory['status'], 'message' => $dataCategory['message']]);
    }

    public function deleteCategoryItem($categoryItemID)
    {
        $dataCategory = $this->setCategoryModel->deleteDataCategoryItem($categoryItemID);
        return response()->json(['status' => $dataCategory['status'], 'message' => $dataCategory['message']]);
    }

    public function showAddCategoryListModal($categoryDetailID)
    {
        if (request()->ajax()) {
            $getDataCategoryItem = $this->masterModel->getListCategoryItem($categoryDetailID);
            $getTag = $this->setCategoryModel->getDataCategoryDetailByID($categoryDetailID);
            $getChecker = $this->masterModel->getChecker($getTag->use_tag);
            // dd($getDataCategoryItem);
            // dd($getChecker);
            return view('app.settings.setTypeCategory.setDetail.dialog.save.addCategoryList', [
                'categoryDetailID' => $categoryDetailID,
                'dataCategoryItem' => $getDataCategoryItem,
                'dataChecker' => $getChecker
            ]);
        }
        return abort(404);
    }
}
