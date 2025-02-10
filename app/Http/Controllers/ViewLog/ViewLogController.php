<?php

namespace App\Http\Controllers\ViewLog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ViewLogController extends Controller
{
    public function viewLogAutoCloseCase(Request $request)
    {
        $date = $request->query('date');
        // dd($date);
        if($date == null){
            $date = date('Y-m-d');
        }
        [$year, $month] = explode('-', $date);
        $logFilePath = storage_path('logs/' . $year . '/' . $month . '/' . 'autoCloseCase-' . $date . '.log');  // หรือ log ที่คุณต้องการใช้
        // dd($logFilePath);
        // ตรวจสอบว่ามีไฟล์ log หรือไม่
        if (File::exists($logFilePath)) {
            // อ่านข้อมูลจาก log file
            $logContents = File::get($logFilePath);
        } else {
            // ถ้าไม่มีไฟล์ log ให้แสดงข้อความแจ้งเตือน
            $logContents = "Log file not found!";
        }

        // ส่งข้อมูลไปยัง view
        return view('log-view', [
            'title' => 'Auto Close Case Logs',
            'url' => 'auto-close',
            'logs' => $logContents,
            'date' => $date
        ]);
    }

    public function viewLogErrorAll(Request $request)
    {
        $date = $request->query('date');
        // dd($date);
        if($date == null){
            $date = date('Y-m-d');
        }
        [$year, $month] = explode('-', $date);
        $logFilePath = storage_path('logs/' . $year . '/' . $month . '/' . 'laravel-' . $date . '.log');  // หรือ log ที่คุณต้องการใช้
        // dd($logFilePath);
        // ตรวจสอบว่ามีไฟล์ log หรือไม่
        if (File::exists($logFilePath)) {
            // อ่านข้อมูลจาก log file
            $logContents = File::get($logFilePath);
        } else {
            // ถ้าไม่มีไฟล์ log ให้แสดงข้อความแจ้งเตือน
            $logContents = "Log file not found!";
        }

        // ส่งข้อมูลไปยัง view
        return view('log-view', [
            'title' => 'Error All Logs',
            'url' => 'error-all',
            'logs' => $logContents,
            'date' => $date
        ]);
    }
}
