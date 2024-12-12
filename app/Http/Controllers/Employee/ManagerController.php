<?php

namespace App\Http\Controllers\Employee;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index()
    {
        $url = request()->segments();
        $urlName = "กำหนดรายการผู้บังคับบัญชา";
        $urlSubLink = "manager";

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.employee.manager.index', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }

    public function showAddManagerModal()
    {
        if(request()->ajax()) {
            return view('app.employee.manager.addManagerModal');
        }

        return abort(404);
    }
}
