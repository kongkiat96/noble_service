<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\Notify\SentNotifyModel;
use Illuminate\Http\Request;

class FunctionTestAllController extends Controller
{
    public function notiTelegram(){
        $tokenDetail = [
            'token' => '7608475353:AAFyUiMT1ejdP5aqPrV0Z3E-W9byVDdULCI',
            'chatId' => '7733159853'
        ];
        $message = "*ประกาศสำคัญ!*\n\nมีข้อความใหม่:\n- หัวข้อ: การประชุมทีม \n- เวลา: `10:00 น.`\n\n[รายละเอียดเพิ่มเติม](https://example.com)";
        $isSent = SentNotifyModel::sentTelegramNotify($message, $tokenDetail);
        return "sss";
    }
}
