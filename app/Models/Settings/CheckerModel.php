<?php

namespace App\Models\Settings;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckerModel extends Model
{
    use HasFactory;

    public function getDataChecker($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbm_checker')->where('deleted', 0);
            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('use_tag', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('use_tag', 'desc')->get();
            }
            $dataCount = $sql->count();

            // dd($sql);
            $newArr = [];
            foreach ($sql as $key => $value) {
                $newArr[] = [
                    'ID' => $value->id,
                    'checker_name' => $value->checker_name,
                    'use_tag'   => $value->use_tag,
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
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => intval($e->getCode()) ?: 500, // ใช้ 500 เป็นค่าดีฟอลต์สำหรับข้อผิดพลาดทั่วไป
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }
    public function saveDataChecker($data)
    {
        try {
            $data['created_at'] = Carbon::now();
            $data['created_user'] = Auth::user()->emp_code;
            DB::connection('mysql')->table('tbm_checker')->insertGetId($data);
            $returnData = [
                'status' => 200,
                'message' => 'Insert Success'
            ];
            return $returnData;
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => intval($e->getCode()) ?: 500, // ใช้ 500 เป็นค่าดีฟอลต์สำหรับข้อผิดพลาดทั่วไป
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function getDataCheckerByID($checkerID)
    {
        try {
            $sql = DB::connection('mysql')->table('tbm_checker')->where('id', $checkerID)->first();
            return $sql;
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => intval($e->getCode()) ?: 500, // ใช้ 500 เป็นค่าดีฟอลต์สำหรับข้อผิดพลาดทั่วไป
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function editDataChecker($checkerID, $data)
    {
        try {
            $data['updated_at'] = Carbon::now();
            $data['updated_user'] = Auth::user()->emp_code;
            DB::connection('mysql')->table('tbm_checker')->where('id', $checkerID)->update($data);
            $returnData = [
                'status' => 200,
                'message' => 'Update Success'
            ];
            return $returnData;
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => intval($e->getCode()) ?: 500, // ใช้ 500 เป็นค่าดีฟอลต์สำหรับข้อผิดพลาดทั่วไป
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function deleteDataChecker($checkerID)
    {
        try {
            DB::connection('mysql')->table('tbm_checker')->where('id', $checkerID)->update([
                'deleted' => 1,
                'updated_at' => now(),
                'updated_user' => Auth::user()->emp_code
            ]);
            $returnData = [
                'status' => 200,
                'message' => 'Delete Success'
            ];
            return $returnData;
        } catch (Exception $e) {
            // บันทึกข้อความผิดพลาดลงใน Log
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => intval($e->getCode()) ?: 500, // ใช้ 500 เป็นค่าดีฟอลต์สำหรับข้อผิดพลาดทั่วไป
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }
}
