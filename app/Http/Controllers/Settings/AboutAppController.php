<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use App\Models\Settings\AboutAppModel;
use Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutAppController extends Controller
{

    private $aboutAppModel;

    public function __construct()
    {
        $this->aboutAppModel = new AboutAppModel();
    }
    public function index()
    {
        $url        = request()->segments();
        $urlName    = "เกี่ยวกับระบบ";
        $urlSubLink = "about-app";

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        $getDataAboutApp = $this->aboutAppModel->getDataAboutApp();
        $totalStorage = $this->getPublicFolderSize();
        // dd($totalStorage);
        return view('app.settings.aboutApp.index', [
            'url'           => $url,
            'urlName'       => $urlName,
            'urlSubLink'    => $urlSubLink,
            'listMenus'     => $getAccessMenus,
            'dataAboutApp' => $getDataAboutApp,
            'totalStorage' => $totalStorage
        ]);
    }

    public function saveAboutAppData(Request $request)
    {
        $data = [
            'company_name' => $request->input('company_name'),
            'show_app_name' => $request->input('show_app_name'),
            'company_address'   => $request->input('company_address'),
            'company_email'   => $request->input('company_email'),
        ];

        // อัปโหลดไฟล์ถ้ามี
        if ($request->hasFile('file')) {
            $files = $request->file('file'); // ตรวจสอบว่า 'file' อาจเป็นอาร์เรย์ของไฟล์
            if (is_array($files)) {
                foreach ($files as $file) {
                    if ($file instanceof \Illuminate\Http\UploadedFile) {
                        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(); // เพิ่ม uniqid เพื่อหลีกเลี่ยงชื่อไฟล์ซ้ำ
                        $file->storeAs('uploads/aboutApp', $filename); // เปลี่ยน path ให้ตรงกับที่ต้องการจัดเก็บ
                        // เก็บชื่อไฟล์ใน array (หากต้องการเก็บหลายไฟล์)
                        $data['about_app_img'][] = $filename;
                    }
                }
            } else {
                // กรณีเป็นไฟล์เดียว
                if ($files instanceof \Illuminate\Http\UploadedFile) {
                    $filename = time() . '_' . uniqid() . '.' . $files->getClientOriginalExtension();
                    $files->storeAs('uploads/aboutApp', $filename);
                    $data['about_app_img'] = $filename; // เก็บชื่อไฟล์ใน array
                }
            }
        }
        // dd($data);
        $saveData = $this->aboutAppModel->saveAboutAppData($data);
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function getPublicFolderSize()
    {
        $folderPath = 'uploads/caseService'; // โฟลเดอร์ที่ต้องการตรวจสอบ
        $limitMB = 500; // ขนาดสูงสุดที่กำหนด (MB)

        // คำนวณขนาดโฟลเดอร์
        $folderSizeBytes = $this->calculateFolderSize($folderPath);
        $folderSizeMB = $folderSizeBytes / 1048576; // แปลงเป็น MB

        // คำนวณเปอร์เซ็นต์
        $percentUsed = ($folderSizeMB / $limitMB) * 100;

        // จำกัดเปอร์เซ็นต์ให้ไม่เกิน 100
        $percentUsed = $percentUsed > 100 ? 100 : $percentUsed;

        // แปลง limit จาก MB เป็นหน่วยที่เหมาะสม
        $limitBytes = $limitMB * 1048576; // แปลง MB เป็น Bytes

        // คำนวณพื้นที่คงเหลือ
        $remainingBytes = $limitBytes - $folderSizeBytes; // คงเหลือใน bytes

        $returnData = [
            'folder' => $folderPath,
            'percent' => number_format($percentUsed, 2),
            'use' => $this->formatSizeUnits($folderSizeBytes),
            'limit' => $this->formatSizeUnits($limitBytes), // แปลง limit เป็นข้อความ
            'remaining' => $this->formatSizeUnits($remainingBytes),
        ];
        return $returnData;
    }

    private function calculateFolderSize($folderPath)
    {
        $totalSize = 0;

        if (Storage::exists($folderPath)) {
            $files = Storage::allFiles($folderPath);
            foreach ($files as $file) {
                $totalSize += Storage::size($file);
            }
        }

        return $totalSize; // ส่งคืนขนาดเป็น bytes
    }

    private function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } else {
            $bytes = $bytes . ' bytes';
        }

        return $bytes;
    }
}
