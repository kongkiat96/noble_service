<?php

namespace App\Http\Controllers\CaseService;

use App\Helpers\CalculateDateHelper;
use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use App\Models\Service\CaseModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CaseServiceController extends Controller
{
    private $caseModel;

    public function __construct()
    {
        $this->caseModel = new CaseModel();
    }
    public function index_case_approve_mt()
    {
        $url = request()->segments();
        $urlName = "รายการอนุมัติแจ้งปัญหาฝ่ายอาคาร (MTs)";
        $urlSubLink = "case-approve-mt";

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.caseService.mt.caseApprove.index', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }

    public function index_case_all_mt()
    {
        $url = request()->segments();
        $urlName = "รายการแจ้งปัญหาฝ่ายอาคาร (MTs)";
        $urlSubLink = "case-all-mt";

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $dateNow = CalculateDateHelper::getCurrentThaiMonthYear();
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.caseService.mt.caseAll.index', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus,
            'dateNow' => $dateNow
        ]);
    }

    public function getDatacaseAction($ticket)
    {
        try {
            // dd($ticket);
            $getCaseDetail = $this->caseModel->getDataCaseDetailApprove($ticket);
            // dd($getCaseDetail);
            if($getCaseDetail['status'] == 200){
                return view('app.caseService.caseDetail.caseDetail_MT',[
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
}
