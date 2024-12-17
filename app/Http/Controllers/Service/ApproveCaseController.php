<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Master\getDataMasterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApproveCaseController extends Controller
{
    public function approveCaseSubManager(){
        $user = Auth::user();
        $url = request()->segments();
        $urlName = "อนุมัติแจ้งงาน";
        $accessMenuSubIDs = $user->accessMenus->pluck('menu_sub_ID')->toArray();
        $getAccessMenus = getDataMasterModel::getMenusName($accessMenuSubIDs);
        return view('app.home.approvecase.caseSubManager.index',[
            'urlName'   => $urlName,
            'url'       => $url,
            'listMenus'         => $getAccessMenus,
        ]);
    }
}
