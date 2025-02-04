<?php

namespace App\Models\Notify;

use App\Models\Service\CaseModel;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class SentNotifyModel extends Model
{
    use HasFactory;

    public static function sentTelegramNotify($message, $tokenDetail)
    {
        $token = $tokenDetail['token']; // ใส่ Telegram bot token
        $getChannel = "https://api.telegram.org/bot{$token}/getUpdates";
        $chatId = $tokenDetail['chatId']; // ใส่ chat ID
        $telegramUrl = "https://api.telegram.org/bot{$token}/sendMessage";

        try {
            $response = Http::post($telegramUrl, [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown',
            ]);
            // Log::info($response);
            return $response->successful();
        } catch (Exception $e) {
            Log::debug('Error in ::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            return false;
        }
    }

    public static function setDataCaseToSend($idCase)
    {
        try {
            $setURL = URL::to('/home');
            // dd($setURL);
            $dataDetail = new CaseModel();
            $searchData = DB::connection('mysql')->table('tbt_case_service')->where('id', $idCase)->where('deleted', 0)->first();
            // dd($searchData);
            if(in_array($searchData->use_tag, ['IT', 'cctv'])) {
                $useCodeCategory = 'IT';
            } else {
                $useCodeCategory = $searchData->use_tag;
            }
            $setTokenTelegram = DB::connection('mysql')->table('tbm_notify')->whereIn('use_tag', [$useCodeCategory, 'all'])->where('notify_type', 'telegram')->where('status_use', 1)->first();
            // dd($setTokenTelegram);
            if (!empty($setTokenTelegram)) {
                $tokenDetail = [
                    'token' => $setTokenTelegram->token,
                    'chatId' => $setTokenTelegram->chat_id
                ];
                $getDataDetail = $dataDetail->getDataCaseDetailApprove($searchData->ticket);
                $mapData = $getDataDetail['message']['datadetail'];
                // dd($getDataDetail['message']['datadetail']);
                $assetCheckNull = $mapData['asset_number'] == null ? '-' : $mapData['asset_number'];
                $managerCheckNull = $mapData['manager_name'] == null ? '-' : $mapData['manager_name'];
                $message = "*Ticket: " . $mapData['ticket'] . "*\n-------------------------\n*รายละเอียดการแจ้งซ่อม*\n- ฝ่ายที่ต้องการแจ้ง : " . $mapData['use_tag'] . " \n- รายการกลุ่มอุปกรณ์ : " . $mapData['category_main_name'] . " \n- รายการประเภทหมวดหมู่ : " . $mapData['category_type_name'] . " \n- อาการที่ต้องการแจ้งปัญหา : " . $mapData['category_detail_name'] . " \n- หมายเลขครุภัณฑ์ : " . $assetCheckNull . " \n- ผู้แจ้งปัญหา : " . $mapData['employee_other_case_name'] . " \n- ผู้บังคับบัญชา : " . $managerCheckNull . " \n- รายละเอียด : " . $mapData['case_detail'] . " \n- เวลา: " . $mapData['created_at'] . "\n\n[คลิกเพื่อตรวจสอบรายการ](" . $setURL . ")";
                // dd($message);
                SentNotifyModel::sentTelegramNotify($message, $tokenDetail);
                return true;
            } else {
                return true;
            }
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::debug('Error in ::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }
}
