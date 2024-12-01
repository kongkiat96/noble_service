<?php

namespace App\Http\Controllers\AssetsManagement;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingAssetsController extends Controller
{
    public function index()
    {
        $url        = request()->segments();
        $urlName    = "ตั้งค่าประเภทสินทรัพย์";
        $urlSubLink = "settings-assets";

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.assetsManagement.settingsAssets.index', [
            'url'           => $url,
            'urlName'       => $urlName,
            'urlSubLink'    => $urlSubLink,
            'listMenus'     => $getAccessMenus
        ]);

    }
}
