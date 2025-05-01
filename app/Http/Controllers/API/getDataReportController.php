<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\API\getDataReportModel;
use Illuminate\Http\Request;

class getDataReportController extends Controller
{
    private $dataReportModel;

    public function __construct()
    {
        $this->dataReportModel = new getDataReportModel();
    }
    public function getDataReport(Request $request)
    {
        // ดึงค่าจาก query string
        $date = $request->query('date');
        $tag = $request->query('tag');
        $parameters = [
            'date' => $date,
            'tag' => $tag,
        ];
        $getDataReport = $this->dataReportModel->getDataReport($parameters);
        // dd($getDataReport);
        $returnData = response()->json([
            'statusCode' => $getDataReport['statusCode'],
            'message' => $getDataReport['message'],
            'data' => $getDataReport['data'],
        ]);

        return $returnData;
    }
}
