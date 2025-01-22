<?php

namespace App\Models\Settings;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotifyModel extends Model
{
    use HasFactory;

    public function searchChatID($token)
    {
        // URL สำหรับ getUpdates
        $getChannel = "https://api.telegram.org/bot{$token}/getUpdates";
        try {
            // ใช้ Guzzle ในการส่ง request
            $client = new Client();
            $response = $client->request('GET', $getChannel, [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);
            // แปลงผลลัพธ์จาก JSON เป็น Array
            $contents = json_decode($response->getBody(), true);
            // ตรวจสอบข้อมูลที่ได้
            if (isset($contents['result']) && count($contents['result']) > 0) {
                // ดึง chat_id จากข้อความแรกที่พบ
                $chatId = $contents['result'][0]['message']['chat']['id'] ?? null;
                $setReturn = [
                    'status' => 200,
                    'chat_id' => $chatId
                ];
            } else {
                // กรณีที่ไม่มีผลลัพธ์จาก Telegram
                $setReturn = [
                    'status' => 404,
                    'chat_id' => null
                ];
            }
        } catch (Exception $e) {
            // จัดการกรณีที่เกิดข้อผิดพลาด
            $setReturn = [
                'status' => $e->getCode(),
                'chat_id' => null
            ];
        } finally {
            return $setReturn;
        }
    }

    public function getDataNotifyTelegram($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbm_notify')->where('deleted', 0)->where('notify_type', 'telegram');
            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('created_at', 'desc')->orderBy('use_tag', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('created_at', 'desc')->orderBy('use_tag', 'desc')->get();
            }
            // $sql = $sql->orderBy('worker.use_tag', 'desc');
            $dataCount = $sql->count();

            // dd($sql);
            $newArr = [];
            foreach ($sql as $key => $value) {
                $newArr[] = [
                    'ID' => $value->id,
                    'token' => $value->token,
                    'chat_id' => $value->chat_id,
                    'notify_type' => $value->notify_type,
                    'status_use' => $value->status_use,
                    'created_at' => $value->created_at,
                    'created_userid' => $value->created_userid,
                    'updated_at' => !empty($value->updated_at) ? $value->updated_at : '-',
                    'updated_userid' => !empty($value->updated_userid) ? $value->updated_userid : '-',
                    'use_tag' => $value->use_tag,
                    'Permission' => Auth::user()->user_system
                ];
            }

            $returnData = [
                "recordsTotal" => $dataCount,
                "recordsFiltered" => $dataCount,
                "data" => $newArr,
            ];
            // dd($returnData);
            return $returnData;
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function saveNotifyTelegramData($data)
    {
        try {
            $data['created_at'] = now();
            $data['created_userid'] = Auth::user()->emp_code;
            $data['notify_type'] = 'telegram';
            $saveDataNotify = DB::connection('mysql')->table('tbm_notify')->insert($data);

            if($saveDataNotify){
                return [
                    'status' => 200,
                    'message' => 'Insert Success'
                ];
            } else {
                return [
                    'status' => 500,
                    'message' => 'Insert Fail'
                ];
            }
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDataNotifyTelegramByID($id)
    {
        try {
            $getData = DB::connection('mysql')->table('tbm_notify')->where('id', $id)->first();
            return $getData;
        } catch (Exception $e) {
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            return [
                'status' => intval($e->getCode()) ?: 500,
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function saveEditNotifyTelegram($data, $id)
    {
        try {
            $data['updated_at'] = now();
            $data['updated_userid'] = Auth::user()->emp_code;
            unset($data['telegramID']);
            $saveDataNotify = DB::connection('mysql')->table('tbm_notify')->where('id', $id)->update($data);

            if($saveDataNotify){
                return [
                    'status' => 200,
                    'message' => 'Update Success'
                ];
            } else {
                return [
                    'status' => 500,
                    'message' => 'Update Fail'
                ];
            }
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function deleteNotifyTelegram($id)
    {
        try {
            // dd($id);
            $deleteData = DB::connection('mysql')->table('tbm_notify')->where('id', $id)->delete();

            if($deleteData){
                return [
                    'status' => 200,
                    'message' => 'Delete Success'
                ];
            } else {
                return [
                    'status' => 500,
                    'message' => 'Delete Fail'
                ];
            }
        } catch (Exception $e) {
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            return [
                'status' => intval($e->getCode()) ?: 500,
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }
}
