<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use App\Models\Master\getDataMasterModel;
use Illuminate\Http\Request;

class CaseApproveSpecialController extends Controller
{
    private $getMaster;
    public function __construct()
    {
        $this->getMaster = new getDataMasterModel();
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
}
