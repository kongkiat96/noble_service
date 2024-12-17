<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Service\CaseModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CaseController extends Controller
{
    private $caseServiceModel;

    public function __construct()
    {
        $this->caseServiceModel = new CaseModel();   
    }
    public function openCaseService(Request $request)
    {
        try {
            // dd($request);
            $saveCase = $this->caseServiceModel->saveOpenCaseService($request);
            return response()->json(['status' => $saveCase['status'], 'message' => $saveCase['message']]);
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
}
