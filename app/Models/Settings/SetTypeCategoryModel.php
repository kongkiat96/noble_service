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
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDataCategoryType($param)
    {
        try {
            // dd($param['use_tag']);
            $sql = DB::connection('mysql')->table('tbm_category_type AS category_type')->where('category_type.deleted', 0)->leftJoin('tbm_category_main AS category_main', 'category_type.category_main_id', '=', 'category_main.id');
            $sql = $sql->select('category_type.*', 'category_main.category_main_name');
            switch ($param['use_tag']) {
                case 'IT':
                    $sql = $sql->where('category_type.use_tag', 'IT');
                    break;
                case 'MT':
                    $sql = $sql->where('category_type.use_tag', 'MT');
                    break;
                default:
                    return false;
                    break;
            }
            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('category_type.created_at', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('category_type.created_at', 'desc')->get();
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
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDataCategoryDetail($param)
    {
        try {
            // dd($param['use_tag']);
            $sql = DB::connection('mysql')->table('tbm_category_detail AS category_detail')->where('category_detail.deleted', 0)
                ->leftJoin('tbm_category_type AS category_type', 'category_detail.category_type_id', '=', 'category_type.id')
                ->leftJoin('tbm_category_main AS category_main', 'category_type.category_main_id', '=', 'category_main.id');
            $sql = $sql->select('category_detail.*', 'category_main.category_main_name', 'category_type.category_type_name');
            switch ($param['use_tag']) {
                case 'IT':
                    $sql = $sql->where('category_detail.use_tag', 'IT');
                    break;
                case 'MT':
                    $sql = $sql->where('category_detail.use_tag', 'MT');
                    break;
                default:
                    return false;
                    break;
            }
            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('category_detail.created_at', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('category_detail.created_at', 'desc')->get();
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
                    'status_tag' => $value->status_tag,
                    'created_at' => $value->created_at,
                    'created_user' => $value->created_user,
                    'updated_at' => !empty($value->updated_at) ? $value->updated_at : '-',
                    'updated_user' => !empty($value->updated_user) ? $value->updated_user : '-',
                    'Permission' => Auth::user()->user_system,
                    'encrypt_id' => encrypt($value->id)
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
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => intval($e->getCode()) ?: 500, // ใช้ 500 เป็นค่าดีฟอลต์สำหรับข้อผิดพลาดทั่วไป
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function saveDataCategoryType($data)
    {
        try {
            $data['created_at'] = now();
            $data['created_user'] = Auth::user()->emp_code;
            // dd($data);
            DB::connection('mysql')->table('tbm_category_type')->insertGetId($data);
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

    public function saveDataCategoryDetail($data)
    {
        try {
            $data['created_at'] = now();
            $data['created_user'] = Auth::user()->emp_code;
            // dd($data);
            DB::connection('mysql')->table('tbm_category_detail')->insertGetId($data);
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

    public function getDataCategoryMainByID($categoryMainID)
    {
        try {
            $getDataCategoryMain = DB::connection('mysql')->table('tbm_category_main')->where('id', $categoryMainID)->first();
            return $getDataCategoryMain;
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

    public function getDataCategoryTypeByID($categoryTypeID)
    {
        try {
            $getDataCategoryType = DB::connection('mysql')->table('tbm_category_type')->where('id', $categoryTypeID)->first();
            return $getDataCategoryType;
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

    public function getDataCategoryDetailByID($categoryDetailID)
    {
        try {
            $getDataCategoryType = DB::connection('mysql')->table('tbm_category_detail')->where('id', $categoryDetailID)->first();
            return $getDataCategoryType;
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
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => intval($e->getCode()) ?: 500, // ใช้ 500 เป็นค่าดีฟอลต์สำหรับข้อผิดพลาดทั่วไป
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function saveEditDataCategoryType($categoryTypeID, $data)
    {
        try {
            $data['updated_at'] = now();
            $data['updated_user'] = Auth::user()->emp_code;
            DB::connection('mysql')->table('tbm_category_type')->where('id', $categoryTypeID)->update($data);
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

    public function saveEditDataCategoryDetail($categoryDetailID, $data)
    {
        try {
            $data['updated_at'] = now();
            $data['updated_user'] = Auth::user()->emp_code;
            DB::connection('mysql')->table('tbm_category_detail')->where('id', $categoryDetailID)->update($data);
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

    public function deleteDataCategoryMain($categoryMainID)
    {
        try {
            DB::connection('mysql')->table('tbm_category_main')->where('id', $categoryMainID)->update([
                'deleted' => 1,
                'updated_at' => now(),
                'updated_user' => Auth::user()->emp_code
            ]);

            DB::connection('mysql')->table('tbm_category_type')->where('category_main_id', $categoryMainID)->update([
                'status_tag' => 0,
                'updated_at' => now(),
                'updated_user' => Auth::user()->emp_code
            ]);

            DB::connection('mysql')->table('tbm_category_detail')->where('category_main_id', $categoryMainID)->update([
                'status_tag' => 0,
                'updated_at' => now(),
                'updated_user' => Auth::user()->emp_code
            ]);
            return [
                'status' => 200,
                'message' => 'Delete Success'
            ];
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

    public function deleteDataCategoryType($categoryTypeID)
    {
        try {
            DB::connection('mysql')->table('tbm_category_type')->where('id', $categoryTypeID)->update([
                'deleted' => 1,
                'updated_at' => now(),
                'updated_user' => Auth::user()->emp_code
            ]);

            DB::connection('mysql')->table('tbm_category_detail')->where('category_type_id', $categoryTypeID)->update([
                'status_tag' => 0,
                'updated_at' => now(),
                'updated_user' => Auth::user()->emp_code
            ]);
            return [
                'status' => 200,
                'message' => 'Delete Success'
            ];
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

    public function deleteDataCategoryDetail($categoryDetailID)
    {
        try {
            DB::connection('mysql')->table('tbm_category_detail')->where('id', $categoryDetailID)->update([
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
            Log::error('Error in ' . get_class($this) . '::' . __FUNCTION__ . ', responseCode: ' . $e->getCode() . ', responseMessage: ' . $e->getMessage());
            // ส่งคืนข้อมูลสถานะเมื่อเกิดข้อผิดพลาด
            return [
                'status' => intval($e->getCode()) ?: 500, // ใช้ 500 เป็นค่าดีฟอลต์สำหรับข้อผิดพลาดทั่วไป
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function getDataCategoryDetailAllByID($categoryDetailID)
    {
        try {
            $getDataCategoryType = DB::connection('mysql')->table('tbm_category_detail AS cd')
                ->leftJoin('tbm_category_main AS cm', 'cd.category_main_id', '=', 'cm.id')
                ->leftJoin('tbm_category_type AS ct', 'cd.category_type_id', '=', 'ct.id')
                ->where('cd.id', $categoryDetailID)
                ->select('cd.*', 'cm.category_main_name', 'ct.category_type_name')->first();
            return $getDataCategoryType;
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

    public function saveCategoryItem($data)
    {
        try {
            // dd($data);
            $getCategoryAllID = $this->getDataCategoryDetailAllByID($data['categoryAllID']);
            $data['category_main_id'] = $getCategoryAllID->category_main_id;
            $data['category_type_id'] = $getCategoryAllID->category_type_id;
            $data['category_detail_id'] = $getCategoryAllID->id;
            $data['use_tag']    = $getCategoryAllID->use_tag;
            $data['created_at'] = now();
            $data['created_user'] = Auth::user()->emp_code;
            unset($data['categoryAllID']);
            // dd($data);
            DB::connection('mysql')->table('tbm_category_item')->insert($data);

            return [
                'status' => 200,
                'message' => 'Save Success'
            ];
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

    public function getDataCategoryItem($param)
    {
        try {
            // dd($param['categoryAllID']);
            $sql = DB::connection('mysql')->table('tbm_category_item')->where('deleted', 0)->where('category_detail_id', $param['categoryAllID']);
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
                    'category_item_name' => $value->category_item_name,
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

    public function getDataCategoryItemByID($categoryItemID)
    {
        try {
            $sql = DB::connection('mysql')->table('tbm_category_item')->where('deleted', 0)->where('id', $categoryItemID)->first();
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

    public function saveEditDataCategoryItem($categoryItemID, $data)
    {
        try {
            // dd($data);
            $data['updated_at'] = now();
            $data['updated_user'] = Auth::user()->emp_code;
            DB::connection('mysql')->table('tbm_category_item')->where('deleted', 0)->where('id', $categoryItemID)->update($data);
            return [
                'status' => 200,
                'message' => 'Success'
            ];
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

    public function deleteDataCategoryItem($categoryItemID)
    {
        try {
            DB::connection('mysql')->table('tbm_category_item')->where('deleted', 0)->where('id', $categoryItemID)->update([
                'deleted' => 1,
                'updated_at' => now(),
                'updated_user' => Auth::user()->emp_code
            ]);

            DB::connection('mysql')->table('tbm_category_list')->where('deleted', 0)->where('category_item_id', $categoryItemID)->update([
                'status_tag' => 0,
                'updated_at' => now(),
                'updated_user' => Auth::user()->emp_code
            ]);
            return [
                'status' => 200,
                'message' => 'Success'
            ];
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

    public function saveCategoryList($data)
    {
        try {
            // dd($data);
            $getCategoryAllID = $this->getDataCategoryItemByID($data['category_item_id']);
            // dd($getCategoryAllID);
            $data['category_main_id'] = $getCategoryAllID->category_main_id;
            $data['category_type_id'] = $getCategoryAllID->category_type_id;
            $data['category_detail_id'] = $getCategoryAllID->category_detail_id;
            $data['category_item_id'] = $getCategoryAllID->id;
            $data['use_tag']    = $getCategoryAllID->use_tag;
            $data['created_at'] = now();
            $data['created_user'] = Auth::user()->emp_code;
            // dd($data);
            unset($data['categoryAllID']);
            DB::connection('mysql')->table('tbm_category_list')->insert($data);
            return [
                'status' => 200,
                'message' => 'Success'
            ];
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

    public function getDataCategoryList($param)
    {
        try {
            // dd($param);
            $getUseTag = $this->getDataCategoryDetailAllByID($param['categoryAllID']);
            // dd($getUseTag);
            $sql = DB::connection('mysql')->table('tbm_category_list AS cl')->where('cl.deleted', 0)->where('cl.use_tag', $getUseTag->use_tag)->where('cl.category_detail_id', $getUseTag->id)
                ->leftJoin('tbm_category_item AS ci', 'ci.id', '=', 'cl.category_item_id')
                ->leftJoin('tbm_checker AS checker', 'checker.id', '=', 'cl.checker_id')
                ->select('cl.*', 'ci.category_item_name', 'checker.checker_name');
            if ($param['start'] == 0) {
                $sql = $sql->limit($param['length'])->orderBy('cl.created_at', 'desc')->get();
            } else {
                $sql = $sql->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('cl.created_at', 'desc')->get();
            }
            $dataCount = $sql->count();
            // dd($sql);
            $newArr = [];
            foreach ($sql as $key => $value) {
                $newArr[] = [
                    'ID' => $value->id,
                    'category_item_name' => $value->category_item_name,
                    'category_list_name' => $value->category_list_name,
                    'checker_name' => $value->checker_name,
                    'pr_po' => !empty($value->pr_po) ? $value->pr_po : '-',
                    'order' => !empty($value->order) ? $value->order : '-',
                    'processing' => !empty($value->processing) ? $value->processing : '-',
                    'sla' => !empty($value->sla) ? $value->sla : '-',
                    'status_tag' => $value->status_tag,
                    'created_at' => $value->created_at,
                    'created_user' => $value->created_user,
                    'updated_at' => !empty($value->updated_at) ? $value->updated_at : '-',
                    'updated_user' => !empty($value->updated_user) ? $value->updated_user : '-',
                    'Permission' => Auth::user()->user_system,
                ];
            }
            // dd($newArr);
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

    public function getDataCategoryListByID($categoryListID)
    {
        try {
            // dd($categoryListID);
            $dataCategory = DB::connection('mysql')->table('tbm_category_list AS cl')->where('cl.deleted', 0)->where('cl.id', $categoryListID)->first();
            return $dataCategory;
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

    public function saveEditDataCategoryList($categoryListID, $data)
    {
        try {
            $data['updated_at'] = now();
            $data['updated_user'] = Auth::user()->emp_code;
            DB::connection('mysql')->table('tbm_category_list')->where('deleted', 0)->where('id', $categoryListID)->update($data);
            return [
                'status' => 200,
                'message' => 'Success'
            ];
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

    public function deleteDataCategoryList($categoryListID)
    {
        try {
            DB::connection('mysql')->table('tbm_category_list')->where('deleted', 0)->where('id', $categoryListID)->update(['deleted' => 1, 'updated_at' => now(), 'updated_user' => Auth::user()->emp_code]);
            return [
                'status' => 200,
                'message' => 'Success'
            ];
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
