<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use App\Models\Master\getDataMasterModel;
use App\Models\Settings\NotifyModel;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
    private $getMaster;
    private $notify;
    public function __construct()
    {
        $this->getMaster = new getDataMasterModel();
        $this->notify = new NotifyModel();
    }
    public function index()
    {
        $url = request()->segments();
        $urlSubLink = "setnotify-telegram";
        $getMenuName = $this->getMaster->searchMenuName($urlSubLink);
        $urlName = $getMenuName->menu_sub_name;

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.settings.notify.index', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }

    public function showAddNotifyModal()
    {
        if (request()->ajax()) {
            return view('app.settings.notify.dialog.save.addToken', []);
        }
        return abort(404);
    }

    public function searchChatID($token,Request $request){
        $setAlertType = $request->alert_type;
        $searchChatID = $this->notify->searchChatID($token,$setAlertType);
        // dd($searchChatID);
        return $searchChatID;
    }

    public function saveNotifyTelegramData(Request $request){
        // dd($request->input());
        $saveNotifyTelegram = $this->notify->saveNotifyTelegramData($request->input());
        return $saveNotifyTelegram;
    }

    public function getDataNotifyTelegram(Request $request){
        $getDataNotifyTelegram = $this->notify->getDataNotifyTelegram($request);
        return response()->json($getDataNotifyTelegram);
    }

    public function showEditNotifyTelegram($notifyID){
        if (request()->ajax()) {
            $getDataTelegram = $this->notify->getDataNotifyTelegramByID($notifyID);
            // dd($getDataTelegram);
            return view('app.settings.notify.dialog.edit.editToken', [
                'dataTelegram' => $getDataTelegram
            ]);
        }
        return abort(404);
    }

    public function saveEditNotifyTelegram(Request $request, $notifyID){
        $saveEditTelegram = $this->notify->saveEditNotifyTelegram($request->input(), $notifyID);
        return $saveEditTelegram;
    }

    public function deleteNotifyTelegram($notifyID){
        $deleteNotifyTelegram = $this->notify->deleteNotifyTelegram($notifyID);
        return $deleteNotifyTelegram;
    }
}
