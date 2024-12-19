<?php

namespace App\Http\Controllers\CaseService;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CaseServiceController extends Controller
{
    public function index_case_approve_mt()
    {
        $url = request()->segments();
        $urlName = "รายการอนุมัติแจ้งปัญหาฝ่ายอาคาร (MTs)";
        $urlSubLink = "case-approve-mt";

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.caseService.mt.caseApprove.index', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }

    public function index_case_all_mt()
    {
        $url = request()->segments();
        $urlName = "รายการแจ้งปัญหาฝ่ายอาคาร (MTs)";
        $urlSubLink = "case-all-mt";

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.caseService.mt.caseAll.index', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }
}
