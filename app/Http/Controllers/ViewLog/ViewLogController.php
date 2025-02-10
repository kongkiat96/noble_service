<?php

namespace App\Http\Controllers\ViewLog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ViewLogController extends Controller
{
    public function viewLogAutoCloseCase(Request $request)
    {
        $date = $request->query('date') ?? date('Y-m-d');
        [$year, $month] = explode('-', $date);
        $logFilePath = storage_path('logs/' . $year . '/' . $month . '/autoCloseCase-' . $date . '.log');

        if (File::exists($logFilePath)) {
            $logContents = File::get($logFilePath);
            // แยกเป็นบรรทัด กลับด้าน และรวมกลับ
            $logContents = implode("\n", array_reverse(explode("\n", $logContents)));
        } else {
            $logContents = "Log file not found!";
        }

        return view('log-view', [
            'title' => 'Auto Close Case Logs',
            'url' => 'auto-close',
            'logs' => $logContents,
            'date' => $date
        ]);
    }

    public function viewLogErrorAll(Request $request)
    {
        $date = $request->query('date') ?? date('Y-m-d');
        [$year, $month] = explode('-', $date);
        $logFilePath = storage_path('logs/' . $year . '/' . $month . '/laravel-' . $date . '.log');

        if (File::exists($logFilePath)) {
            $logContents = File::get($logFilePath);
            // แยกเป็นบรรทัด กลับด้าน และรวมกลับ
            $logContents = implode("\n", array_reverse(explode("\n", $logContents)));
        } else {
            $logContents = "Log file not found!";
        }

        return view('log-view', [
            'title' => 'Error All Logs',
            'url' => 'error-all',
            'logs' => $logContents,
            'date' => $date
        ]);
    }
}
