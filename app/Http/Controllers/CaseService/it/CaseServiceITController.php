<?php

namespace App\Http\Controllers\CaseService\it;

use App\Http\Controllers\Controller;
use App\Models\CaseService\it\CaseServiceITModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CaseServiceITController extends Controller
{
    private $caseServiceModel;

    public function __construct()
    {
        $this->caseServiceModel = new CaseServiceITModel();
    }
    public function getDataCaseOpenIT(Request $request)
    {
        try {
            // dd($request);
            $getAllCase = $this->caseServiceModel->getDataCaseOpenIT($request);
            return response()->json($getAllCase);
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDataCaseDoingIT(Request $request)
    {
        try {
            $getAllCase = $this->caseServiceModel->getDataCaseDoingIT($request);
            return response()->json($getAllCase);
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDataCaseSuccessIT(Request $request)
    {
        try {
            $getAllCase = $this->caseServiceModel->getDataCaseSuccessIT($request);
            return response()->json($getAllCase);
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDataCaseWaitApproveIT(Request $request)
    {
        try {
            // dd($request);
            $getAllCase = $this->caseServiceModel->getDataCaseWaitApproveIT($request);
            return response()->json($getAllCase);
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }
}
