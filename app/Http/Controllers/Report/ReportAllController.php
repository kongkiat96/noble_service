<?php

namespace App\Http\Controllers\Report;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use App\Models\Master\getDataMasterModel;
use Illuminate\Http\Request;

class ReportAllController extends Controller
{
    private $getMaster;
    public function __construct()
    {
        $this->getMaster = new getDataMasterModel();
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

        switch ($type) {
            case 'it':
                return view('app.report.it.index', [
                    'url' => $url,
                    'urlName' => $urlName,
                    'urlSubLink' => $urlSubLink,
                    'listMenus' => $getAccessMenus
                ]);
                break;
            case 'mt':
                return view('app.report.mt.index', [
                    'url' => $url,
                    'urlName' => $urlName,
                    'urlSubLink' => $urlSubLink,
                    'listMenus' => $getAccessMenus
                ]);
                break;
            default:
                return abort(404);
        }
    }
}
