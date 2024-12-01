<?php

namespace App\Http\Controllers\AssetsManagement;

use App\Http\Controllers\Controller;
use App\Models\AssetsManagement\SettingAssetsTagModel;
use Illuminate\Http\Request;

class SettingAssetsTagController extends Controller
{
    private $settingAssets;

    public function __construct()
    {
        $this->settingAssets = new SettingAssetsTagModel();
    }

    public function showAddAssetsTagModal()
    {
        if (request()->ajax()) {
            return view('app.assetsManagement.settingsAssets.dialog.save.addAssetTag', [
                
            ]);
        }
        return abort(404);
    }

    public function saveDataAssetsTag(Request $request)
    {
        $dataAssetsTag = $this->settingAssets->saveDataAssetsTag($request->input());
        return response()->json(['status' => $dataAssetsTag['status'], 'message' => $dataAssetsTag['message']]);
    }

    public function getDataAssetsTag(Request $request)
    {
        $getData = $this->settingAssets->getDataAssetsTag($request);
        return response()->json($getData);
    }

    public function showEditAssetsTag($assetTag)
    {
        if (request()->ajax()) {
            $getDataAssetTag = $this->settingAssets->getDataAssetTagByID($assetTag);

            // dd($getDataAssetTag);
            return view('app.assetsManagement.settingsAssets.dialog.edit.editAssetTag', [
                'getDataAssetTag' => $getDataAssetTag,
            ]);
        }
        return abort(404);
    }

    public function editAssetsTag($assetTag, Request $request)
    {
        $dataAssetsTag = $this->settingAssets->editAssetsTag($assetTag, $request->input());
        return response()->json(['status' => $dataAssetsTag['status'], 'message' => $dataAssetsTag['message']]);
    }

    public function deleteAssetsTag($assetTagID)
    {
        $deleteAssetTag = $this->settingAssets->deleteAssetTag($assetTagID);
        return response()->json(['status' => $deleteAssetTag['status'], 'message' => $deleteAssetTag['message']]);
    }

    public function showAsstesTag($assetTagID)
    {
        if (request()->ajax()) {
            $getDataAssetTag = $this->settingAssets->getDataAssetTagByID($assetTagID);
            // dd($getDataAssetTag);
            return view('app.assetsManagement.settingsAssets.dialog.view.viewAssetTag', [
                'getDataAssetTag' => $getDataAssetTag,
            ]);
        }
        return abort(404);
    }
}
