<?php

namespace App\Helpers;

use Laravolt\Avatar\Avatar;

class serviceCenter
{
    public static function generateProfile($name)
{
    // รายการคำที่ต้องการเซ็นเซอร์
    $badWords = ['ศพ', 'ฆร', 'หำ', 'ศx', 'สบ','ศบ' ]; // เพิ่มคำที่ต้องการแปลง

    // ดึง instance ของ Avatar
    $avatar = app(\Laravolt\Avatar\Avatar::class);

    // ตั้งค่าฟอนต์ภาษาไทย (ตรวจสอบให้แน่ใจว่าไฟล์ฟอนต์อยู่ในตำแหน่งที่ถูกต้อง)
    $fontPath = public_path('fonts/THSarabunNew/THSarabunNew.ttf');

    // ดึงอักษรตัวแรกของชื่อและนามสกุล (หรือชื่อที่มีช่องว่าง)
    $words = explode(' ', trim($name)); // แยกคำตามช่องว่าง
    $initials = mb_substr($words[0], 0, 1); // ตัวแรกของชื่อ
    if (isset($words[1])) {
        $initials .= mb_substr($words[1], 0, 1); // ตัวแรกของนามสกุล (ถ้ามี)
    }

    // ตรวจสอบว่าคำย่ออยู่ในรายการคำไม่เหมาะสมหรือไม่
    if (in_array($initials, $badWords)) {
        $initials = 'XX'; // แทนที่ด้วย XX
    }

    // สร้างรูป Avatar และเปลี่ยนให้เป็น SVG
    return $avatar->create($initials)
        ->setFont($fontPath)
        ->setShape('circle') // ทำให้เป็นวงกลม
        ->toSvg(); // เปลี่ยนเป็น SVG
}

    
}
