<?php

namespace App\Http\Controllers\Report;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use App\Models\Master\getDataMasterModel;
use App\Models\Report\ReportAllModel;
use Illuminate\Http\Request;

class ReportAllController extends Controller
{
    private $getMaster;
    private $reportModel;
    public function __construct()
    {
        $this->getMaster = new getDataMasterModel();
        $this->reportModel = new ReportAllModel();
    }
    public function index($type)
    {
        $url = request()->segments();
        $urlSubLink = "report-" . $type;
        $getMenuName = $this->getMaster->searchMenuName($urlSubLink);
        $urlName = $getMenuName->menu_sub_name;

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();
        // dd($setTextLowercase);
        $getListCategoryMain = $this->getMaster->getDataCategoryMain($type);
        $getStatusWork = $this->getMaster->getDataStatusWork($type, 'admin');
        // $getListCategoryType = $this->getMaster->getListCategoryType($detailCase['category_main']);
        // $getListCategoryDetail = $this->getMaster->getListCategoryDetail($detailCase['category_type']);
        switch ($type) {
            case 'it':
                return view('app.report.it.index', [
                    'url' => $url,
                    'urlName' => $urlName,
                    'urlSubLink' => $urlSubLink,
                    'listMenus' => $getAccessMenus,
                    'dataCategoryMain' => $getListCategoryMain,
                    'statusWork'    => $getStatusWork,
                    'reportType'  => $type
                ]);
                break;
            case 'mt':
                return view('app.report.mt.index', [
                    'url' => $url,
                    'urlName' => $urlName,
                    'urlSubLink' => $urlSubLink,
                    'listMenus' => $getAccessMenus,
                    'dataCategoryMain' => $getListCategoryMain,
                    'statusWork'    => $getStatusWork,
                    'reportType'  => $type
                ]);
                break;
            default:
                return abort(404);
        }
    }

    public function getDataReport(Request $request, $type)
    {
        $getAllReport = $this->reportModel->getDataReport($request, $type);
        return response()->json($getAllReport);
    }
}
