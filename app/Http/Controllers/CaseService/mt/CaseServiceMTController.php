<?php

namespace App\Http\Controllers\CaseService\mt;

use App\Http\Controllers\Controller;
use App\Models\CaseService\mt\CaseServiceMTModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CaseServiceMTController extends Controller
{
    private $caseServiceModel;

    public function __construct()
    {
        $this->caseServiceModel = new CaseServiceMTModel();
    }
    public function getDataCaseOpenMT(Request $request)
    {
        try {
            // dd($request);
            $getAllCase = $this->caseServiceModel->getDataCaseOpenMT($request);
            return response()->json($getAllCase);
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

    public function getDataCaseDoingMT(Request $request)
    {
        try {
            $getAllCase = $this->caseServiceModel->getDataCaseDoingMT($request);
            return response()->json($getAllCase);
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

    public function realtimeCaseNewCountMT()
    {
        $countCaseNew = $this->caseServiceModel->realtimeCaseNewCountMT();
        // dd($countCaseNew);
        return response()->json(['count' => $countCaseNew]);
    }

    public function realtimeCaseDoingCountMT()
    {
        $countCaseDoing = $this->caseServiceModel->realtimeCaseDoingCountMT();
        // dd($countCaseDoing);
        return response()->json(['count' => $countCaseDoing]);
    }
}