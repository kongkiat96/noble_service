<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Master\getDataMasterModel;
use App\Models\Service\ApproveCaseModel;
use App\Models\Service\CaseModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApproveCaseController extends Controller
{
    private $approveCaseModel;
    private $caseModel;

    public function __construct()
    {
        $this->approveCaseModel = new ApproveCaseModel();
        $this->caseModel = new CaseModel();
    }
    public function approveCaseSubManager()
    {
        $user = Auth::user();
        $url = request()->segments();
        $urlName = "อนุมัติแจ้งงาน";
        $accessMenuSubIDs = $user->accessMenus->pluck('menu_sub_ID')->toArray();
        $getAccessMenus = getDataMasterModel::getMenusName($accessMenuSubIDs);
        return view('app.home.approvecase.caseSubManager.index', [
            'urlName'   => $urlName,
            'url'       => $url,
            'listMenus'         => $getAccessMenus,
        ]);
    }

    public function getDataCaseAll(Request $request)
    {
        try {
            // dd($request);
            $getAllCase = $this->approveCaseModel->getDataCaseAll($request);
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

    public function approveCaseManager(Request $request, $caseID)
    {
        try {
            // dd($request);
            $decryptCaseID = decrypt($caseID);
            // dd($decryptCaseID);
            $saveCase = $this->approveCaseModel->saveApproveCaseManager($request, $decryptCaseID);
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

    public function approveCasePadding(Request $request, $caseID)
    {
        try {
            // dd($request);
            $decryptCaseID = decrypt($caseID);
            // dd($decryptCaseID);
            $saveCase = $this->approveCaseModel->saveApproveCasePadding($request, $decryptCaseID);
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

    public function caseCheckWork(Request $request, $caseID)
    {
        try {
            // dd($request->input());
            $decryptCaseID = decrypt($caseID);
            // dd($decryptCaseID);
            $saveCase = $this->approveCaseModel->saveCaseCheckWork($request->input(), $decryptCaseID);
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

    public function realtimeCaseApproveCount()
    {
        $countCaseApprove = $this->approveCaseModel->countCaseApprove(Auth::user()->map_employee);
        return response()->json(['count' => $countCaseApprove]);
    }

    public function realtimeCaseApproveCountTag($type)
    {
        // dd($type);
        $countCaseApprove = $this->approveCaseModel->countCaseApproveType($type);
        // dd($countCaseApprove);
        return response()->json(['count' => $countCaseApprove]);
    }

    public function getDataApproveMT(Request $request)
    {
        $getCaseMT = $this->approveCaseModel->getDataApproveMT($request);
        return response()->json($getCaseMT);
    }

    public function realtimeCaseApproveCountFU()
    {
        $countCaseApprove = $this->approveCaseModel->countCaseApproveFU();
        // dd($countCaseApprove);
        return response()->json(['count' => $countCaseApprove]);
    }

    public function realtimeCaseCheckWorkCount()
    {
        $countCaseApprove = $this->approveCaseModel->countCaseCheckWork();
        // dd($countCaseApprove);
        return response()->json(['count' => $countCaseApprove]);
    }

    public function getDataApproveFU(Request $request)
    {
        $getCaseFU = $this->approveCaseModel->getDataApproveFU($request);
        // dd($getCaseFU);
        return response()->json($getCaseFU);
    }

    public function getDataCaseCheckWork(Request $request)
    {
        $getCaseMT = $this->approveCaseModel->getDataCaseCheckWork($request);
        return response()->json($getCaseMT);
    }
}
