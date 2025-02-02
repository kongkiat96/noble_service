<?php

namespace App\Http\Controllers\CaseService;

use App\Helpers\CalculateDateHelper;
use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use App\Models\Master\getDataMasterModel;
use App\Models\Service\CaseModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mpdf\Mpdf;

class CaseServiceController extends Controller
{
    private $caseModel;
    private $getMaster;

    public function __construct()
    {
        $this->caseModel = new CaseModel();
        $this->getMaster = new getDataMasterModel();
    }
    public function index_case_approve_mt()
    {
        $url = request()->segments();
        $urlSubLink = "case-approve-mt";
        $getMenuName = $this->getMaster->searchMenuName($urlSubLink);
        $urlName = $getMenuName->menu_sub_name;

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

    public function index_case_approve_it()
    {
        $url = request()->segments();
        $urlSubLink = "case-approve-it";
        $getMenuName = $this->getMaster->searchMenuName($urlSubLink);
        $urlName = $getMenuName->menu_sub_name;

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.caseService.it.caseApprove.index', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }

    public function index_case_approve_cctv()
    {
        $url = request()->segments();
        $urlSubLink = "case-approve-cctv";
        $getMenuName = $this->getMaster->searchMenuName($urlSubLink);
        $urlName = $getMenuName->menu_sub_name;

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.caseService.cctv.caseApprove.index', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }

    public function index_case_approve_permission()
    {
        $url = request()->segments();
        $urlSubLink = "case-approve-permission";
        $getMenuName = $this->getMaster->searchMenuName($urlSubLink);
        $urlName = $getMenuName->menu_sub_name;

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.caseService.permission.caseApprove.index', [
            'url' => $url,
            'urlName' => $urlName,
            'urlSubLink' => $urlSubLink,
            'listMenus' => $getAccessMenus
        ]);
    }

    public function index_case_all_mt()
    {
        $url = request()->segments();
        $urlSubLink = "case-all-mt";
        $getMenuName = $this->getMaster->searchMenuName($urlSubLink);
        $urlName = $getMenuName->menu_sub_name;

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

    public function index_case_all_it()
    {
        $url = request()->segments();
        $urlSubLink = "case-all-it";
        $getMenuName = $this->getMaster->searchMenuName($urlSubLink);
        $urlName = $getMenuName->menu_sub_name;

        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $dateNow = CalculateDateHelper::getCurrentThaiMonthYear();
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.caseService.it.caseAll.index', [
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
            $detailCase = $getCaseDetail['message']['datadetail'];
            // dd($detailCase);
            $setTextLowercase = strtolower($getCaseDetail['message']['datadetail']['use_tag_code']);
            $categoryMain = $getCaseDetail['message']['datadetail']['category_main'];
            $categoryType = $getCaseDetail['message']['datadetail']['category_type'];
            $categoryDetail = $getCaseDetail['message']['datadetail']['category_detail'];
            $categoryItem = $getCaseDetail['message']['datadetail']['case_item'];
            $getCategoryItem = $this->caseModel->getCategoryItem($categoryMain, $categoryType, $categoryDetail);
            $getCategoryList = $this->caseModel->getCategoryList($categoryItem);
            $getStatusWork = $this->getMaster->getDataStatusWork($setTextLowercase, 'admin');

            if(in_array($getCaseDetail['message']['datadetail']['use_tag_code'], ['IT', 'cctv', 'permission'])) {
                $useCodeCategory = 'IT';
            } else {
                $useCodeCategory = $detailCase['use_tag_code'];
            }

            $getListCategoryMain = $this->getMaster->getDataCategoryMain($useCodeCategory);
            $getListCategoryType = $this->getMaster->getListCategoryType($detailCase['category_main']);
            $getListCategoryDetail = $this->getMaster->getListCategoryDetail($detailCase['category_type']);
            // dd($getListCategoryMain);
            $getDataWorker = $this->getMaster->getDataWorker($setTextLowercase);
            $workerArray = json_decode($detailCase['worker'], true);
            $workerNames = collect($workerArray)
                ->pluck('name')
                ->implode(', ');
            // dd($workerNames);

            $getDataChecker = $this->getMaster->getChecker($setTextLowercase);
            $checkerArray = json_decode($detailCase['checker'], true);
            $checkerNames = collect($checkerArray)
                ->pluck('name')
                ->implode(', ');

            if ($getCaseDetail['status'] == 200) {
                if ($getCaseDetail['message']['datadetail']['tag_work'] == 'case_success') {
                    $setView = 'caseDetailAddPrice';
                } else {
                    if(in_array($getCaseDetail['message']['datadetail']['use_tag_code'], ['IT', 'cctv', 'permission'])) {
                        $setView = 'caseDetail_IT';
                    } else {
                        $setView = 'caseDetail_' . $getCaseDetail['message']['datadetail']['use_tag_code'];
                    }
                    
                }
                // dd($setView);
                return view('app.caseService.caseDetail.' . $setView, [
                    'data' => $getCaseDetail['message']['datadetail'],
                    'image' => $getCaseDetail['message']['dataimage'],
                    'imageDoing' => $getCaseDetail['message']['dataimageDoing'],
                    'categoryItem' => $getCategoryItem,
                    'categoryList' => $getCategoryList,
                    'getDataWorker' => $getDataWorker,
                    'getStatusWork' => $getStatusWork,
                    'workerNames' => $workerNames,
                    'getDataChecker' => $getDataChecker,
                    'checkerNames' => $checkerNames,
                    'dataCategoryMain' => $getListCategoryMain,
                    'dataCategoryType' => $getListCategoryType,
                    'dataCategoryDetail' => $getListCategoryDetail
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

    public function caseDoingAction(Request $request, $caseID)
    {
        try {
            $saveCase = $this->caseModel->saveCaseDoingAction($request, $caseID);
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

    public function realtimeCaseNewCountTag($type)
    {
        $countCaseNew = $this->caseModel->realtimeCaseNewCountTag($type);
        // dd($countCaseNew);
        return response()->json(['count' => $countCaseNew]);
    }

    public function realtimeCaseDoingCountTag($type)
    {
        $countCaseDoing = $this->caseModel->realtimeCaseDoingCountTag($type);
        // dd($countCaseDoing);
        return response()->json(['count' => $countCaseDoing]);
    }

    public function realtimeCaseSuccessCountTag($type)
    {
        $countCaseSuccess = $this->caseModel->realtimeCaseSuccessCountTag($type);
        // dd($countCaseSuccess);
        return response()->json(['count' => $countCaseSuccess]);
    }

    public function casePrintWork($ticket)
    {
        // dd($ticket);
        $getCaseDetail = $this->caseModel->getDataCaseDetailApprove($ticket);
        $setTextLowercase = strtolower($getCaseDetail['message']['datadetail']['use_tag_code']);
        $categoryMain = $getCaseDetail['message']['datadetail']['category_main'];
        $categoryType = $getCaseDetail['message']['datadetail']['category_type'];
        $categoryDetail = $getCaseDetail['message']['datadetail']['category_detail'];
        $categoryItem = $getCaseDetail['message']['datadetail']['case_item'];
        $getCategoryItem = $this->caseModel->getCategoryItem($categoryMain, $categoryType, $categoryDetail);
        $getCategoryList = $this->caseModel->getCategoryList($categoryItem);
        $getStatusWork = $this->getMaster->getDataStatusWork($setTextLowercase, 'admin');

        $getDataWorker = $this->getMaster->getDataWorker($setTextLowercase);
        $setWorker = $getCaseDetail['message']['datadetail'];
        $workerArray = json_decode($setWorker['worker'], true);
        $workerNames = collect($workerArray)
            ->pluck('name')
            ->implode(', ');
        // dd($workerNames);

        $getDataChecker = $this->getMaster->getChecker($setTextLowercase);
        $setChecker = $getCaseDetail['message']['datadetail'];
        $checkerArray = json_decode($setChecker['checker'], true);
        $checkerNames = collect($checkerArray)
            ->pluck('name')
            ->implode(', ');

        if ($getCaseDetail['message']['datadetail']['use_tag_code'] == 'IT') {
            $setTitle = 'ฝ่ายไอที (ICT)';
        } else {
            $setTitle = 'ฝ่ายช่าง (CMM)';
        }
        // dd($setImage);
        // เตรียมข้อมูลที่จะแสดงใน PDF
        $html = view('app.caseService.caseDetail.casePrintWork', [
            'data' => $getCaseDetail['message']['datadetail'],
            'image' => $getCaseDetail['message']['dataimage'],
            'imageDoing' => $getCaseDetail['message']['dataimageDoing'],
            'categoryItem' => $getCategoryItem,
            'categoryList' => $getCategoryList,
            'getDataWorker' => $getDataWorker,
            'getStatusWork' => $getStatusWork,
            'workerNames' => $workerNames,
            'getDataChecker' => $getDataChecker,
            'checkerNames' => $checkerNames,
            'setTitle'  => $setTitle
        ])->render(); // render HTML จาก view ที่จะแสดงผล

        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font_size' => 12,
            'default_font' => 'sarabun',
            'fontDir' => array_merge($fontDirs, [
                public_path('fonts/THSarabunNew'), // ตำแหน่งที่เก็บฟอนต์
            ]),
            'fontdata' => array_merge($fontData, [
                'sarabun' => [
                    'R' => 'THSarabunNew.ttf',
                    'B' => 'THSarabunNew Bold.ttf',
                    'I' => 'THSarabunNew Italic.ttf',
                    'BI' => 'THSarabunNew BoldItalic.ttf'
                ]
            ]),
            'image_scale' => 0.5, // ปรับสเกลรูปภาพ
        ]);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->SetMargins(2, 2, 5); // ระยะขอบ 15 มม. ด้านซ้าย ขวา และด้านบน
        // dd($mpdf->fontdata);
        // dd(mb_detect_encoding($html));

        $mpdf->WriteHTML($html); // เขียน HTML ลง PDF

        // สร้างไฟล์ PDF และดาวน์โหลด
        return $mpdf->Output($getCaseDetail['message']['datadetail']['ticket'].'.pdf', 'I'); // 'I' หมายถึงการแสดงใน browser, 'D' สำหรับการดาวน์โหลด
    }
}
