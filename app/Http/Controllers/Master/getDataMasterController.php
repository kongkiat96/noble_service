<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\getDataMasterModel;
use Illuminate\Http\Request;

class getDataMasterController extends Controller
{
    private $masterModel;

    public function __construct()
    {
        $this->masterModel = new getDataMasterModel;
    }

    public function getDataCompany($id)
    {
        $getDataCompany = $this->masterModel->getDataCompanyForID($id);
        // dd(response()->json($getDataCompany));
        return response()->json($getDataCompany);
    }

    public function getDataDepartment($id)
    {
        $getDataDepartment = $this->masterModel->getDataDepartmentForID($id);
        // dd(response()->json($getDataDepartment));
        return response()->json($getDataDepartment);
    }

    public function getDataGroup($departmentID)
    {
        $getDataGroup = $this->masterModel->getDataGroupOfDepartment($departmentID);
        // dd($getDataGroup);
        return response()->json($getDataGroup);
    }

    public function getDataPrefixName()
    {
        $getDataPrefixName = $this->masterModel->getDataPrefixName();
        // dd(response()->json($getDataPrefixName));
        return response()->json($getDataPrefixName);
    }

    public function getDataProvince()
    {
        $getDataProvince = $this->masterModel->getDataProvince();

        return response()->json($getDataProvince);
    } 

    public function getDataAmphoe($provinceCode)
    {
        $getDataAmphoe = $this->masterModel->getDataAmphoe($provinceCode);
        // dd($getDataAmphoe);
        return response()->json($getDataAmphoe);
    }

    public function getDataTambon($aumphoeID)
    {
        $getDataTambon = $this->masterModel->getDataTambon($aumphoeID);
        // dd($getDataTambon);
        return response()->json($getDataTambon);
    }

    public function getDataBankList()
    {
        $getDataBankList = $this->masterModel->getDataBankList();
        // dd($getDataBankList);
        return response()->json($getDataBankList);
    }

    public function getDataCategoryType($categoryMainID)
    {
        $getListCategoryType = $this->masterModel->getListCategoryType($categoryMainID);
        // dd($getListCategoryType);
        return response()->json($getListCategoryType);
    }

    public function getDataCategoryDetail($categoryTypeID)
    {
        $getListCategoryDetail = $this->masterModel->getListCategoryDetail($categoryTypeID);       
        // dd($getListCategoryDetail); 
        return response()->json($getListCategoryDetail);
    }

    public function getDataCategoryList($categoryItemID)
    {
        $getListCategoryList = $this->masterModel->getListCategoryList($categoryItemID);       
        // dd($getListCategoryList); 
        return response()->json($getListCategoryList);
    }

    public function getDataAboutEmployee($empID)
    {
        $getDataEmployee = $this->masterModel->getDataAboutEmployee($empID);
        // dd($getDataEmployee);
        return response()->json($getDataEmployee);
    }

    public function getDataManager($empID)
    {
        $getDataManager = $this->masterModel->getDataManager($empID);
        // dd($getDataManager);
        return response()->json($getDataManager);
    }

    public function getDataCategoryTag($useTag)
    {
        $getDataCategoryMain = $this->masterModel->getDataCategoryMain($useTag);
        // dd($getDataCategoryMain);
        return response()->json($getDataCategoryMain);
    }
}
