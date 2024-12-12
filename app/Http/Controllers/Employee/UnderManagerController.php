<?php

namespace App\Http\Controllers\Employee;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UnderManagerController extends Controller
{
    public function index()
    {
        $url = request()->segments();
        $urlName = "กำหนดรายการผู้บังคับบัญชา";
        $urlSubLink = "under-manager";

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.employee.underManager.index', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }
}
