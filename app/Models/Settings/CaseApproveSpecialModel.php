<?php

namespace App\Models\Settings;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CaseApproveSpecialModel extends Model
{
    use HasFactory;

    public function getDataCaseApproveSpecial($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbm_set_approve_case AS set_approve_case')
                ->leftJoin('tbm_category_main AS category_main', 'set_approve_case.category_main', '=', 'category_main.id')
                ->leftJoin('tbm_category_type AS category_type', 'set_approve_case.category_type', '=', 'category_type.id')
                ->leftJoin('tbm_category_detail AS category_detail', 'set_approve_case.category_detail', '=', 'category_detail.id')
                ->where('set_approve_case.deleted', 0);
            $sql = $sql->select('category_main.category_main_name', 'category_type.category_type_name', 'category_detail.category_detail_name', 'set_approve_case.*');
            switch ($param['use_tag']) {
                case 'cctv':
                    $sql = $sql->where('set_approve_case.use_tag', 'cctv');
                    break;
                case 'permission':
                    $sql = $sql->where('set_approve_case.use_tag', 'permission');
                    break;
                default:
                    return false;
                    break;
            }
            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('set_approve_case.created_at', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('set_approve_case.created_at', 'desc')->get();
            }
            // $sql = $sql->orderBy('created_at', 'desc');
            $dataCount = $sql->count();

            // dd($sql);
            $newArr = [];
            foreach ($sql as $key => $value) {
                $newArr[] = [
                    'ID' => $value->id,
                    'category_main_name' => $value->category_main_name,
                    'category_type_name' => $value->category_type_name,
                    'category_detail_name' => $value->category_detail_name,
                    'use_tag' => $value->use_tag,
                    'status_use' => $value->status_use,
                    'created_at' => $value->created_at,
                    'created_user' => $value->created_user,
                    'updated_at' => !empty($value->updated_at) ? $value->updated_at : '-',
                    'updated_user' => !empty($value->updated_user) ? $value->updated_user : '-',
                    'Permission' => Auth::user()->user_system,
                ];
            }

            $returnData = [
                "recordsTotal" => $dataCount,
                "recordsFiltered" => $dataCount,
                "data" => $newArr,
            ];
            // dd($returnData);
            return $returnData;
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

    public function getCaseApproveSpecialByID($caseID)
    {
        try {
            $getDataCaseApprove = DB::connection('mysql')->table('tbm_set_approve_case')->where('id', $caseID)->first();
            return $getDataCaseApprove;
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
    public function saveCaseCCTVData($data)
    {
        try {
            $searchData = $this->searchDataCaseApprove($data);
            if($searchData['status'] == 200){
                $data['use_tag'] = 'cctv';
                $data['created_at'] = Carbon::now();
                $data['created_user'] = Auth::user()->emp_code;
                $result = DB::connection('mysql')->table('tbm_set_approve_case')->insert($data);
                return [
                    'status' => 200,
                    'message' => 'Insert Success'
                ];
            } else {
                return [
                    'status' => '23000',
                    'message' => 'Found Data'
                ];
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

    public function saveCasePermissionData($data)
    {
        try {
            $searchData = $this->searchDataCaseApprove($data);
            if($searchData['status'] == 200){
                $data['use_tag'] = 'permission';
                $data['created_at'] = Carbon::now();
                $data['created_user'] = Auth::user()->emp_code;
                $result = DB::connection('mysql')->table('tbm_set_approve_case')->insert($data);
                return [
                    'status' => 200,
                    'message' => 'Insert Success'
                ];
            } else {
                return [
                    'status' => '23000',
                    'message' => 'Found Data'
                ];
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

    public function saveEditCaseApprove($caseID, $data)
    {
        try {
            $searchData = $this->searchDataCaseApprove($data);
            // dd($searchData);
            if($searchData['status'] == 200){
                // dd($data);
                $data['updated_at'] = Carbon::now();
                $data['updated_user'] = Auth::user()->emp_code;
                $result = DB::connection('mysql')->table('tbm_set_approve_case')->where('id', $caseID)->update($data);
                return [
                    'status' => 200,
                    'message' => 'Update Success'
                ];
            } else {
                return [
                    'status' => '23000',
                    'message' => 'Found Data'
                ];
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

    public function deleteCaseApprove($caseID)
    {
        try {
            $data['deleted'] = 1;
            $data['updated_at'] = Carbon::now();
            $data['updated_user'] = Auth::user()->emp_code;
            $result = DB::connection('mysql')->table('tbm_set_approve_case')->where('id', $caseID)->update($data);
            return [
                'status' => 200,
                'message' => 'Delete Success'
            ];
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

    private function searchDataCaseApprove($dataToSearch)
    {
        try {
            // dd($searchData);
            $searchData = DB::connection('mysql')->table('tbm_set_approve_case')
            ->where('category_main', $dataToSearch['category_main'])
            ->where('category_type', $dataToSearch['category_type'])
            ->where('category_detail', $dataToSearch['category_detail'])
            // ->where('use_tag', $dataToSearch['use_tag'])
            ->where('deleted', 0)
            ->first();

            // dd($searchData);
            if(empty($searchData)){
                return [
                    'status' => 200,
                    'message' => 'Not Found'
                ];
            } else {
                return [
                    'status' => '23000',
                    'message' => 'Found Data'
                ];
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
