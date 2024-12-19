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

    public function getDataCaseAll(Request $request)
    {
        try {
            // dd($request);
            $getAllCase = $this->caseServiceModel->getDataCaseAll($request);
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

    public function getDataCaseDetail($ticket)
    {
        try {
            // dd($request);
            // dd($ticket);
            $getCaseDetail = $this->caseServiceModel->getDataCaseDetailApprove($ticket);
            // dd($getCaseDetail);
            if($getCaseDetail['status'] == 200){
                return view('app.home.approvecase.caseSubManager.caseDetail',[
                    'data' => $getCaseDetail['message']['datadetail'],
                    'image' => $getCaseDetail['message']['dataimage']
                ]);
            } else {
                return response()->json(['status' => $getCaseDetail['status'], 'message' => $getCaseDetail['message']]);
            }
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

    public function getDataCaseDetailApprove($ticket)
    {
        try {
            // dd($ticket);
            $getCaseDetail = $this->caseServiceModel->getDataCaseDetailApprove($ticket);
            // dd($getCaseDetail);
            if($getCaseDetail['status'] == 200){
                return view('app.caseService.detailApprove.caseDetail',[
                    'data' => $getCaseDetail['message']['datadetail'],
                    'image' => $getCaseDetail['message']['dataimage']
                ]);
            } else {
                return response()->json(['status' => $getCaseDetail['status'], 'message' => $getCaseDetail['message']]);
            }
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

    public function getDataCaseDetailHistory(Request $request)
    {
        try {
            $getCaseDetail = $this->caseServiceModel->getDataCaseDetailHistory($request);
            return response()->json($getCaseDetail);
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
