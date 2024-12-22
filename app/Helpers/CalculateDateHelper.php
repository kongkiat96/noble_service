<?php
namespace App\Helpers;

use Carbon\Carbon;
use Exception;


class CalculateDateHelper
{
    /**
     * แปลงวันที่เป็น พ.ศ. และคำนวณอายุงาน
     *
     * @param string $date วันที่ในรูปแบบ 'Y-m-d'
     * @return array ผลลัพธ์ที่แปลงแล้วและอายุงาน
     */
    public static function convertDateAndCalculateServicePeriod($date)
    {
        // แปลงวันที่เป็น พ.ศ.
        $carbonDate = Carbon::parse($date);
        $thYear = $carbonDate->year + 543;
        $formattedDate = $carbonDate->translatedFormat("d F") . " พ.ศ. " . $thYear;

        // คำนวณอายุงาน
        $currentDate = Carbon::now();
        $diff = $carbonDate->diff($currentDate);

        $servicePeriod = [
            'years' => $diff->y,
            'months' => $diff->m,
            'days' => $diff->d,
        ];

        return [
            'formatted_date' => $formattedDate,
            'service_period' => $servicePeriod,
        ];
    }

    public static function getCurrentThaiMonthYear() {
        $thaiMonths = [
            1 => 'มกราคม',
            2 => 'กุมภาพันธ์',
            3 => 'มีนาคม',
            4 => 'เมษายน',
            5 => 'พฤษภาคม',
            6 => 'มิถุนายน',
            7 => 'กรกฎาคม',
            8 => 'สิงหาคม',
            9 => 'กันยายน',
            10 => 'ตุลาคม',
            11 => 'พฤศจิกายน',
            12 => 'ธันวาคม'
        ];
    
        $currentMonth = (int) date('m'); // ดึงเดือนปัจจุบัน
        $currentYear = (int) date('Y') + 543; // ดึงปีปัจจุบันและแปลงเป็น พ.ศ.
    
        return $thaiMonths[$currentMonth] . ' ' . $currentYear;
    }
}