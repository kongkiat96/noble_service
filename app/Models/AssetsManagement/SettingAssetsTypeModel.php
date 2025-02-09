<?php

namespace App\Models\AssetsManagement;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingAssetsTypeModel extends Model
{
    use HasFactory;

    public function getDataAssetsType($param)
    {
        try {
            $sql = DB::connection('mysql')->table('tbm_asset_type AS at')
            ->leftJoin('tbm_asset_tag AS tag', 'at.asset_tag_id', '=', 'tag.ID')
            ->select('at.*','tag.asset_tag_name','tag.asset_tag_color')
            ->where('at.deleted', 0);
            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('tag.asset_tag_name', 'desc')->orderBy('at.created_at','desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('tag.asset_tag_name', 'desc')->orderBy('at.created_at','desc')->get();
            }
            // $sql = $sql->orderBy('created_at', 'desc');
            $dataCount = $sql->count();

            // dd($sql);
            $newArr = [];
            foreach ($sql as $key => $value) {
                $newArr[] = [
                    'ID' => $value->id,
                    'asset_type_name' => $value->asset_type_name,
                    'asset_tag_name' => $value->asset_tag_name,
                    'asset_tag_color' => $value->asset_tag_color,
                    'status_type' => $value->status_type,
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
    public function saveDataAssetsType($data)
    {
        try {
            $data['created_at'] = now();
            $data['created_user'] = Auth::user()->emp_code;
            DB::connection('mysql')->table('tbm_asset_type')->insertGetId($data);
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
}
