<?php

namespace App\Models\Settings;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SetStatusModel extends Model
{
    use HasFactory;

    public function __construct()
    {
        $this->getDatabase = DB::connection('mysql');
    }

    public function gatDataStatus($request)
    {
        $query = $this->getDatabase->table('tbm_status_work AS statusWork')
            ->leftJoin('tbm_flag_type AS flag', 'statusWork.flag_type', '=', 'flag.ID')
            ->select('statusWork.ID', 'statusWork.status_name', 'statusWork.status_use', 'statusWork.status', 'flag.type_work')
            ->where('statusWork.deleted', 0)
            ->where('flag.deleted', 0);
        // คำสั่งเรียงลำดับ (Sorting)
        $columns = ['statusWork.ID', 'statusWork.status_name', 'statusWork.status_use', 'statusWork.status', 'flag.type_work'];
        $orderColumn = $columns[$request->input('order.0.column')];
        $orderDirection = $request->input('order.0.dir');
        $query->orderBy($orderColumn, $orderDirection);

        // คำสั่งค้นหา (Searching)
        $searchValue = $request->input('search.value');
        if (!empty($searchValue)) {
            $query->where(function ($query) use ($columns, $searchValue) {
                foreach ($columns as $column) {
                    $query->orWhere('status_name', 'like', '%' . $searchValue . '%');
                }
            });
        }

        $recordsTotal = $query->count();
        // รับค่าที่ส่งมาจาก DataTables
        $start = $request->input('start');
        $length = $request->input('length');

        $data = $query->offset($start)
            ->limit($length)
            ->orderBy('status', 'DESC')
            ->orderBy('flag_type', 'DESC')
            ->get();

        $output = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal, // หรือจำนวนรายการที่ผ่านการค้นหา
            'data' => $data,
        ];

        // dd($output);

        return $output;
    }

    public function gatDataFlagType($request)
    {
        $query = $this->getDatabase->table('tbm_flag_type')->where('deleted', 0);

        // คำสั่งเรียงลำดับ (Sorting)
        $columns = ['ID', 'flag_name', 'type_work'];
        $orderColumn = $columns[$request->input('order.0.column')];
        $orderDirection = $request->input('order.0.dir');
        $query->orderBy($orderColumn, $orderDirection);

        // คำสั่งค้นหา (Searching)
        $searchValue = $request->input('search.value');
        if (!empty($searchValue)) {
            $query->where(function ($query) use ($columns, $searchValue) {
                foreach ($columns as $column) {
                    $query->orWhere('flag_name', 'like', '%' . $searchValue . '%');
                    $query->orWhere('type_work', 'like', '%' . $searchValue . '%');
                }
            });
        }

        $recordsTotal = $query->count();
        // รับค่าที่ส่งมาจาก DataTables
        $start = $request->input('start');
        $length = $request->input('length');

        $data = $query->offset($start)
            ->limit($length)
            ->get();

        $output = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal, // หรือจำนวนรายการที่ผ่านการค้นหา
            'data' => $data,
        ];

        return $output;
    }

    public function saveDataStatus($getData)
    {
        try {
            // dd(Auth::user()->emp_code);
            $saveToDB = $this->getDatabase->table('tbm_status_work')->insertGetId([
                'status_name'   => $getData['statusName'],
                'status_use'    => $getData['statusUse'],
                'flag_type'     => $getData['flagType'],
                'status'        => $getData['statusOfStatus'],
                'created_user'  => Auth::user()->emp_code,
                'created_at'    => Carbon::now()
            ]);
            // dd($saveToDB);
            $returnStatus = [
                'status'    => 200,
                'message'   => 'Success',
                // 'ID'        => $saveToDB
            ];
        } catch (Exception $e) {
            $returnStatus = [
                'status'    => intval($e->getCode()),
                'message'   => $e->getMessage()
            ];
        } finally {
            return $returnStatus;
        }
    }

    public function saveDataGroupStatus($getData)
    {
        try {
            $searchData = $this->getDatabase->table('tbm_group_status')
                ->where(function ($query) use ($getData) {
                    $query->where('group_status_th', $getData['group_status_th'])
                        ->orWhere('group_status_en', $getData['group_status_en']);
                })
                ->where('deleted', 0)->first();
            // dd($searchData);

            if (empty($searchData)) {
                $getData['created_at'] = Carbon::now();
                $getData['created_user'] = Auth::user()->emp_code;
                $saveToDB = $this->getDatabase->table('tbm_group_status')->insertGetId($getData);

                return [
                    'status' => 200,
                    'message' => 'Success',
                    'ID' => $saveToDB
                ];
            } else {
                return [
                    'status' => '23000',
                    'message' => 'Duplicate Data'
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

    public function showEditStatus($statusID)
    {
        $getData = $this->getDatabase->table('tbm_status_work')->where('ID', $statusID)->get();
        // dd($getData);
        return $getData;
    }

    public function editStatus($dataEdit, $statusID)
    {
        try {
            $this->getDatabase->table('tbm_status_work')->where('ID', $statusID)->update([
                'status_name'   => $dataEdit['edit_statusName'],
                'status_use'    => $dataEdit['edit_statusUse'],
                'status'        => $dataEdit['edit_statusOfStatus'],
                'flag_type'     => $dataEdit['edit_flagType'],
                'update_user'  => Auth::user()->emp_code,
                'update_at'    => Carbon::now()
            ]);

            $returnStatus = [
                'status'    => 200,
                'message'   => 'Edit Success'
            ];
        } catch (Exception $e) {
            $returnStatus = [
                'status'    => intval($e->getCode()),
                'message'   => $e->getMessage()
            ];
        } finally {
            return $returnStatus;
        }
    }

    public function deleteStatus($statusID)
    {
        try {
            $this->getDatabase->table('tbm_status_work')->where('ID', $statusID)->update([
                'deleted'      => 1,
                'update_user'       => Auth::user()->emp_code,
                'update_at'         => Carbon::now()
            ]);
            $returnStatus = [
                'status'    => 200,
                'message'   => 'Delete Success'
            ];
        } catch (Exception $e) {
            $returnStatus = [
                'status'    => intval($e->getCode()),
                'message'   => $e->getMessage()
            ];
        } finally {
            return $returnStatus;
        }
    }

    public function saveDataFlagType($getFlagType)
    {
        try {
            // dd($getFlagType);
            $saveToDB = $this->getDatabase->table('tbm_flag_type')->insertGetId([
                'flag_name'   => $getFlagType['flagName'],
                'type_work'    => $getFlagType['typeWork'],
                'created_user'  => Auth::user()->emp_code,
                'created_at'    => Carbon::now()
            ]);
            // dd($saveToDB);
            $returnStatus = [
                'status'    => 200,
                'message'   => 'Success',
                // 'ID'        => $saveToDB
            ];
        } catch (Exception $e) {
            $returnStatus = [
                'status'    => intval($e->getCode()),
                'message'   => $e->getMessage()
            ];

            Log::info($returnStatus);
        } finally {
            return $returnStatus;
        }
    }

    public function showEditFlagType($flagID)
    {
        $getData = $this->getDatabase->table('tbm_flag_type')->where('ID', $flagID)->get();
        // dd($getData);
        return $getData;
    }

    public function editFlagType($dataEdit, $flagID)
    {
        try {
            $this->getDatabase->table('tbm_flag_type')->where('ID', $flagID)->update([
                'flag_name'   => $dataEdit['edit_flagName'],
                'type_work'    => $dataEdit['edit_typeWork'],
                'update_user'  => Auth::user()->emp_code,
                'update_at'    => Carbon::now()
            ]);

            $returnStatus = [
                'status'    => 200,
                'message'   => 'Edit Success'
            ];
        } catch (Exception $e) {
            $returnStatus = [
                'status'    => intval($e->getCode()),
                'message'   => $e->getMessage()
            ];
        } finally {
            return $returnStatus;
        }
    }

    public function deleteFlagType($flagID)
    {
        try {
            $this->getDatabase->table('tbm_flag_type')->where('ID', $flagID)->update([
                'deleted'           => 1,
                'update_user'       => Auth::user()->emp_code,
                'update_at'         => Carbon::now()
            ]);
            $returnStatus = [
                'status'    => 200,
                'message'   => 'Delete Success'
            ];
        } catch (Exception $e) {
            $returnStatus = [
                'status'    => intval($e->getCode()),
                'message'   => $e->getMessage()
            ];
        } finally {
            return $returnStatus;
        }
    }

    public function gatDataGroupStatus($param)
    {
        try {
            $query = $this->getDatabase->table('tbm_group_status')->where('deleted', 0);
            if ($param['start'] == 0) {
                $query = $query->limit($param['length'])->orderBy('created_at', 'desc')->orderBy('status_tag', 'desc')->get();
            } else {
                $query = $query->offset($param['start'])
                    ->limit($param['length'])
                    ->orderBy('created_at', 'desc')->orderBy('status_tag', 'desc')->get();
            }

            $dataCount = $query->count();

            // dd($query);
            $newArr = [];
            foreach ($query as $key => $value) {
                $newArr[] = [
                    'ID' => $value->id,
                    'group_status_th' => $value->group_status_th,
                    'group_status_en' => $value->group_status_en,
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

    public function getDataGroupStatusByID($groupStatusID)
    {
        try {
            // dd($groupStatusID);
            $getData = $this->getDatabase->table('tbm_group_status')->where('id', $groupStatusID)->first();
            // dd($getData);
            return $getData;
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

    public function editGroupStatus($getData, $groupStatusID)
    {
        try {
            $groupStatusID = decrypt($groupStatusID);
            // dd($groupStatusID);
            $searchDuplicate = $this->getDatabase->table('tbm_group_status')->where(function ($query) use ($getData, $groupStatusID) {
                $query->where('group_status_th', $getData['group_status_th'])
                    ->orWhere('group_status_en', $getData['group_status_en']);
            })->where('id', '!=', $groupStatusID)->first();

            if ($searchDuplicate) {
                return [
                    'status' => '23000',
                    'message' => 'Duplicate Data'
                ];
            } else {
                $getData['updated_at'] = Carbon::now();
                $getData['updated_user'] = Auth::user()->emp_code;
                unset($getData['groupStatusID']);
                $this->getDatabase->table('tbm_group_status')->where('id', $groupStatusID)->update($getData);

                return [
                    'status' => 200,
                    'message' => 'Edit Success'
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

    public function deleteGroupStatus($groupStatusID)
    {
        try {
            // dd($groupStatusID);
            $this->getDatabase->table('tbm_group_status')->where('id', $groupStatusID)->update([
                'deleted'      => 1,
                'updated_user'       => Auth::user()->emp_code,
                'updated_at'         => Carbon::now()
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
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }
}
