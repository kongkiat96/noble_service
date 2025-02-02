<?php

namespace App\Helpers;

use Laravolt\Avatar\Avatar;

class serviceCenter
{
    public static function generateProfile($name)
    {
        // ดึง instance ของ Avatar
        $avatar = app(Avatar::class);

        // ตั้งค่าฟอนต์ภาษาไทย (ตรวจสอบให้แน่ใจว่าไฟล์ฟอนต์อยู่ในตำแหน่งที่ถูกต้อง)
        $fontPath = public_path('fonts/THSarabunNew/THSarabunNew.ttf');

        // สร้างรูป Avatar และเปลี่ยนให้เป็น SVG
        return $avatar->create($name)
            ->setFont($fontPath)
            ->setShape('circle') // ทำให้เป็นวงกลม
            ->toSvg(); // เปลี่ยนเป็น SVG
    }
}
