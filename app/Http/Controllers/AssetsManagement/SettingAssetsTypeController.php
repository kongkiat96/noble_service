<?php

namespace App\Http\Controllers\AssetsManagement;

use App\Http\Controllers\Controller;
use App\Models\AssetsManagement\SettingAssetsTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingAssetsTypeController extends Controller
{
    private $settingAssets;

    public function __construct()
    {
        $this->settingAssets = new SettingAssetsTypeModel();
    }
    public function getDataAssetsType(Request $request) 
    {
        $getData = $this->settingAssets->getDataAssetsType($request);
        return response()->json($getData);
    }

    public function showAddAssetsTypeModal()
    {
        if (request()->ajax()) {
            $getDataAssetsTag = DB::connection('mysql')->table('tbm_asset_tag')->where('deleted',0)->where('status_tag', 1)->get();
            // dd($getDataAssetsTag);
            return view('app.assetsManagement.settingsAssets.dialog.save.addAssetType', [
                'getDataAssetsTag' => $getDataAssetsTag
            ]);
        }
        return abort(404);
    }

    public function saveDataAssetsType(Request $request)
    {
        $dataAssetsType = $this->settingAssets->saveDataAssetsType($request->input());
        return response()->json(['status' => $dataAssetsType['status'], 'message' => $dataAssetsType['message']]);
    }
}
