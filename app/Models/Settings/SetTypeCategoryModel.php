<?php

namespace App\Models\Settings;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SetTypeCategoryModel extends Model
{
    use HasFactory;

    public function getDataCategoryMain($param)
    {
        try {
            // dd($param['use_tag']);
            $sql = DB::connection('mysql')->table('tbm_category_main')->where('deleted', 0);
            switch ($param['use_tag']) {
                case 'IT':
                    $sql = $sql->where('use_tag', 'IT');
                    break;
                case 'MT':
                    $sql = $sql->where('use_tag', 'MT');
                    break;
                default:
                    return false;
                    break;
            }
            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('created_at', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('created_at', 'desc')->get();
            }
            // $sql = $sql->orderBy('created_at', 'desc');
            $dataCount = $sql->count();

            // dd($sql);
            $newArr = [];
            foreach ($sql as $key => $value) {
                $newArr[] = [
                    'ID' => $value->id,
                    'category_main_name' => $value->category_main_name,
                    'status_tag' => $value->status_tag,
                    'created_at' => $value->created_at,
                    'created_user' => $value->created_user,
                    'updated_at' => !empty($value->updated_at) ? $value->updated_at : '-',
                    'updated_user' => !empty($value->updated_user) ? $value->updated_user : '-',
                    'Permission' => Auth::user()->user_system
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
    public function saveDataCategoryMain($data)
    {
        try {
            $data['created_at'] = now();
            $data['created_user'] = Auth::user()->emp_code;
            DB::connection('mysql')->table('tbm_category_main')->insertGetId($data);
            $returnData = [
                'status' => 200,
                'message' => 'Insert Success'
            ];

            return $returnData;
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => intval($e->getCode()) ?: 500, // ใช้ 500 เป็นค่าดีฟอลต์สำหรับข้อผิดพลาดทั่วไป
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function getDataCategoryMainByID($categoryMainID)
    {
        try {
            $getDataCategoryMain = DB::connection('mysql')->table('tbm_category_main')->where('id', $categoryMainID)->first();
            return $getDataCategoryMain;
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => intval($e->getCode()) ?: 500, // ใช้ 500 เป็นค่าดีฟอลต์สำหรับข้อผิดพลาดทั่วไป
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function saveEditDataCategoryMain($categoryMainID, $data)
    {
        try {
            $data['updated_at'] = now();
            $data['updated_user'] = Auth::user()->emp_code;
            DB::connection('mysql')->table('tbm_category_main')->where('id', $categoryMainID)->update($data);
            $returnData = [
                'status' => 200,
                'message' => 'Update Success'
            ];

            return $returnData;
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => intval($e->getCode()) ?: 500, // ใช้ 500 เป็นค่าดีฟอลต์สำหรับข้อผิดพลาดทั่วไป
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function deleteDataCategoryMain($categoryMainID)
    {
        try {
            
            DB::connection('mysql')->table('tbm_category_main')->where('id', $categoryMainID)->update([
                'deleted' => 1,
                'updated_at' => now(),
                'updated_user' => Auth::user()->emp_code
            ]);
            return [
                'status' => 200,
                'message' => 'Delete Success'
            ];
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::debug('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => intval($e->getCode()) ?: 500, // ใช้ 500 เป็นค่าดีฟอลต์สำหรับข้อผิดพลาดทั่วไป
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }
}
