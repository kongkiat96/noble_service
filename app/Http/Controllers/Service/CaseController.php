<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Master\getDataMasterModel;
use App\Models\Service\CaseModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CaseController extends Controller
{
    private $caseServiceModel;
    private $getMaster;

    public function __construct()
    {
        $this->caseServiceModel = new CaseModel();
        $this->getMaster = new getDataMasterModel();
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

    public function getDataCaseCheckWork(Request $request)
    {
        try {
            // dd($request);
            $getCaseCheckWork = $this->caseServiceModel->getDataCaseCheckWork($request);
            return response()->json($getCaseCheckWork);
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

    public function showCaseCheckWork($caseID)
    {
        if (request()->ajax()) {
            // dd($caseID);
            $getTicket = DB::connection('mysql')->table('tbt_case_service')->where('id', $caseID)->select('ticket')->first();
            // dd($getTicket);
            $getCaseDetail = $this->caseServiceModel->getDataCaseDetailApprove($getTicket->ticket);
            // dd($getCaseDetail);
            $categoryMain = $getCaseDetail['message']['datadetail']['category_main'];
            $categoryType = $getCaseDetail['message']['datadetail']['category_type'];
            $categoryDetail = $getCaseDetail['message']['datadetail']['category_detail'];
            $categoryItem = $getCaseDetail['message']['datadetail']['case_item'];
            $getCategoryItem = $this->caseServiceModel->getCategoryItem($categoryMain, $categoryType, $categoryDetail);
            $getCategoryList = $this->caseServiceModel->getCategoryList($categoryItem);

            $getDataWorker = $this->getMaster->getDataWorker('mt');
            // dd($getDataWorker);
            $getStatusWork = $this->getMaster->getDataStatusWork('mt', 'user');
            // dd($getStatusWork);
            $setWorker = $getCaseDetail['message']['datadetail'];
            $workerArray = json_decode($setWorker['worker'], true);
            $workerNames = collect($workerArray)
                ->pluck('name')
                ->implode(', ');

            $getDataChecker = $this->getMaster->getChecker('mt');
            $setChecker = $getCaseDetail['message']['datadetail'];
            $checkerArray = json_decode($setChecker['checker'], true);
            $checkerNames = collect($checkerArray)
                ->pluck('name')
                ->implode(', ');

            return view('app.home.service.userCheck.dialog.caseCheckWork', [
                'data' => $getCaseDetail['message']['datadetail'],
                'image' => $getCaseDetail['message']['dataimage'],
                'imageDoing' => $getCaseDetail['message']['dataimageDoing'],
                'categoryItem' => $getCategoryItem,
                'categoryList' => $getCategoryList,
                'getDataWorker' => $getDataWorker,
                'getStatusWork' => $getStatusWork,
                'workerNames' => $workerNames,
                'getDataChecker' => $getDataChecker,
                'checkerNames' => $checkerNames
            ]);
        }
        return abort(404);
    }

    public function showCaseCheckHistory($caseID)
    {
        if (request()->ajax()) {
            // dd($caseID);
            $getTicket = DB::connection('mysql')->table('tbt_case_service')->where('id', $caseID)->select('ticket')->first();
            // dd($getTicket);
            $getCaseDetail = $this->caseServiceModel->getDataCaseDetailApprove($getTicket->ticket);
            // dd($getCaseDetail);
            $categoryMain = $getCaseDetail['message']['datadetail']['category_main'];
            $categoryType = $getCaseDetail['message']['datadetail']['category_type'];
            $categoryDetail = $getCaseDetail['message']['datadetail']['category_detail'];
            $categoryItem = $getCaseDetail['message']['datadetail']['case_item'];
            $getCategoryItem = $this->caseServiceModel->getCategoryItem($categoryMain, $categoryType, $categoryDetail);
            $getCategoryList = $this->caseServiceModel->getCategoryList($categoryItem);

            $getDataWorker = $this->getMaster->getDataWorker('mt');
            // dd($getDataWorker);
            $getStatusWork = $this->getMaster->getDataStatusWork('mt', 'user');
            // dd($getStatusWork);
            $setWorker = $getCaseDetail['message']['datadetail'];
            $workerArray = json_decode($setWorker['worker'], true);
            $workerNames = collect($workerArray)
                ->pluck('name')
                ->implode(', ');

            $getDataChecker = $this->getMaster->getChecker('mt');
            $setChecker = $getCaseDetail['message']['datadetail'];
            $checkerArray = json_decode($setChecker['checker'], true);
            $checkerNames = collect($checkerArray)
                ->pluck('name')
                ->implode(', ');

            return view('app.home.service.userCheck.dialog.caseCheckHistory', [
                'data' => $getCaseDetail['message']['datadetail'],
                'image' => $getCaseDetail['message']['dataimage'],
                'imageDoing' => $getCaseDetail['message']['dataimageDoing'],
                'categoryItem' => $getCategoryItem,
                'categoryList' => $getCategoryList,
                'getDataWorker' => $getDataWorker,
                'getStatusWork' => $getStatusWork,
                'workerNames' => $workerNames,
                'getDataChecker' => $getDataChecker,
                'checkerNames' => $checkerNames
            ]);
        }
        return abort(404);
    }

    public function getDataCaseDetail($ticket)
    {
        try {
            // dd($request);
            // dd($ticket);
            $getCaseDetail = $this->caseServiceModel->getDataCaseDetailApprove($ticket);
            // dd($getCaseDetail);
            if ($getCaseDetail['status'] == 200) {
                return view('app.home.approvecase.caseSubManager.caseDetail', [
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
            if ($getCaseDetail['status'] == 200) {
                if ($getCaseDetail['message']['datadetail']['tag_work'] == 'case_success_user') {
                    $categoryMain = $getCaseDetail['message']['datadetail']['category_main'];
                    $categoryType = $getCaseDetail['message']['datadetail']['category_type'];
                    $categoryDetail = $getCaseDetail['message']['datadetail']['category_detail'];
                    $categoryItem = $getCaseDetail['message']['datadetail']['case_item'];
                    $getCategoryItem = $this->caseServiceModel->getCategoryItem($categoryMain, $categoryType, $categoryDetail);
                    $getCategoryList = $this->caseServiceModel->getCategoryList($categoryItem);
                    $getStatusWork = $this->getMaster->getDataStatusWork('mt', 'admin');

                    $getDataWorker = $this->getMaster->getDataWorker('mt');
                    $setWorker = $getCaseDetail['message']['datadetail'];
                    $workerArray = json_decode($setWorker['worker'], true);
                    $workerNames = collect($workerArray)
                        ->pluck('name')
                        ->implode(', ');
                    // dd($workerNames);

                    $getDataChecker = $this->getMaster->getChecker('mt');
                    $setChecker = $getCaseDetail['message']['datadetail'];
                    $checkerArray = json_decode($setChecker['checker'], true);
                    $checkerNames = collect($checkerArray)
                        ->pluck('name')
                        ->implode(', ');

                    return view('app.caseService.caseDetail.caseDetailCheckWork', [
                        'data' => $getCaseDetail['message']['datadetail'],
                        'image' => $getCaseDetail['message']['dataimage'],
                        'imageDoing' => $getCaseDetail['message']['dataimageDoing'],
                        'categoryItem' => $getCategoryItem,
                        'categoryList' => $getCategoryList,
                        'getDataWorker' => $getDataWorker,
                        'getStatusWork' => $getStatusWork,
                        'workerNames' => $workerNames,
                        'getDataChecker' => $getDataChecker,
                        'checkerNames' => $checkerNames
                    ]);
                } else {
                    return view('app.caseService.caseDetail.caseDetail', [
                        'data' => $getCaseDetail['message']['datadetail'],
                        'image' => $getCaseDetail['message']['dataimage']
                    ]);
                }
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
            // dd($request);
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

    public function realtimeCaseCheckWorkByUserCount()
    {
        $countCaseCheckWork = $this->caseServiceModel->realtimeCaseCheckWorkByUserCount();
        return response()->json(['count' => $countCaseCheckWork]);
    }
}
