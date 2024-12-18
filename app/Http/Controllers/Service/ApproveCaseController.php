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

    public function realtimeCaseApproveCount(){
        $countCaseApprove = $this->caseModel->countCaseApprove(Auth::user()->map_employee);
        return response()->json(['count' => $countCaseApprove]);
    }
}
