<?php

namespace App\Models\API;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class getDataReportModel extends Model
{
    use HasFactory;

    public function getDataReport($requestData)
    {
        try {
            // dd($requestData);
            $queryData = DB::connection('mysql')->table('tbt_case_service AS cs')
                ->leftJoin('tbm_category_main AS cm', 'cs.category_main', '=', 'cm.id')
                ->leftJoin('tbm_category_type AS ct', 'cs.category_type', '=', 'ct.id')
                ->leftJoin('tbm_category_detail AS cd', 'cs.category_detail', '=', 'cd.id')
                ->leftJoin('tbm_category_item AS ci', 'cs.case_item', '=', 'ci.id')
                ->leftJoin('tbm_category_list AS cl', 'cs.case_list', '=', 'cl.id')
                ->leftJoin('tbt_case_service_history AS csh_manager', function ($join) {
                    $join->on('cs.id', '=', 'csh_manager.case_service_id')
                        ->whereIn('csh_manager.case_status', [
                            DB::raw("CONCAT('manager_approve_', cs.use_tag)"),
                            DB::raw("CONCAT('reject_manager_approve_', cs.use_tag)")
                        ])
                        ->whereRaw('csh_manager.id = (SELECT MIN(id) FROM tbt_case_service_history 
                                                      WHERE case_service_id = cs.id 
                                                      AND created_at = csh_manager.created_at)');
                })



                ->leftJoin('tbt_case_service_history AS csh_manager_department', function ($join) {
                    $join->on('cs.id', '=', 'csh_manager_department.case_service_id')
                        ->whereColumn('csh_manager_department.case_status', DB::raw("CONCAT('manager_', cs.use_tag, '_approve')"));
                })
                ->leftJoin('tbt_case_service_history AS csh_check_user', function ($join) {
                    $join->on('cs.id', '=', 'csh_check_user.case_service_id')
                        ->whereIn('csh_check_user.case_status', ['case_success_user', 'auto_close_case', 'auto_close_case_wait_recheck', DB::raw("CONCAT('reject_manager_approve_', cs.use_tag)"), DB::raw("CONCAT('reject_manager_', cs.use_tag, '_approve')")]);
                })
                ->leftJoin('tbt_employee AS em', 'cs.employee_other_case', '=', 'em.ID')
                ->leftJoin('tbm_branch AS br', 'em.branch_id', '=', 'br.id')

                ->leftJoin('tbm_status_work AS sw', 'cs.case_status', '=', 'sw.ID')
                ->leftJoin('tbm_group_status AS gs', 'sw.group_status', '=', 'gs.id')

                ->where('cs.deleted', 0);

            // if(!empty($requestData)){
            // dd($requestData);
            if (!empty($requestData['date'])) {
                $queryData->where('cs.created_at', 'LIKE', '%' . $requestData['date'] . '%');
            }

            if (!empty($requestData['tag'])) {
                $queryData->where('cs.use_tag', $requestData['tag']);
            }

            $queryData->select([
                'cs.id',
                'cs.ticket',
                DB::raw("(
                    CASE 
                        WHEN sw.status_name IS NOT NULL THEN sw.status_name 
                        ELSE (
                            CASE cs.case_status
                                WHEN 'wait_manager_approve' THEN 'รอการอนุมัติจากผู้บังคับบัญชา'
                                WHEN 'padding' THEN 'รอดำเนินการแก้ไข'
                                WHEN 'wait_manager_mt_approve' THEN 'รอการอนุมัติจากฝ่ายช่าง'
                                WHEN 'openCaseWaitApprove' THEN 'แจ้งปัญหาการใช้งาน / รอการอนุมัติจากผู้บังคับบัญชา'
                                WHEN 'wait_manager_it_approve' THEN 'รอการอนุมัติจากฝ่ายไอที'
                                WHEN 'wait_manager_hr_approve' THEN 'รอการอนุมัติจากฝ่าย HR'
                                WHEN 'manager_approve_MT' THEN 'อนุมัติจากผู้บังคับบัญชา / รอการอนุมัติจากฝ่ายช่าง'
                                WHEN 'manager_approve_IT' THEN 'อนุมัติจากผู้บังคับบัญชา / รอการอนุมัติจากฝ่ายไอที'
                                WHEN 'manager_approve_cctv' THEN 'อนุมัติจากผู้บังคับบัญชา / รอการอนุมัติจากฝ่ายไอที'
                                WHEN 'manager_approve_permission' THEN 'อนุมัติจากผู้บังคับบัญชา / รอการอนุมัติจากฝ่าย Hr'
                                WHEN 'manager_mt_approve' THEN 'อนุมัติจากฝ่ายช่าง / รอดำเนินงาน'
                                WHEN 'manager_it_approve' THEN 'อนุมัติจากฝ่ายไอที / รอดำเนินงาน'
                                WHEN 'manager_cctv_approve' THEN 'อนุมัติจากฝ่ายไอที / รอดำเนินงาน'
                                WHEN 'manager_permission_approve' THEN 'อนุมัติจากฝ่าย Hr / รอดำเนินงาน'
                                WHEN 'reject_manager_approve_MT' THEN 'ไม่อนุมัติจากผู้บังคับบัญชา'
                                WHEN 'reject_manager_approve_IT' THEN 'ไม่อนุมัติจากผู้บังคับบัญชา'
                                WHEN 'reject_manager_approve_permission' THEN 'ไม่อนุมัติจากผู้บังคับบัญชา'
                                WHEN 'reject_manager_approve_cctv' THEN 'ไม่อนุมัติจากผู้บังคับบัญชา'
                                WHEN 'reject_manager_mt_approve' THEN 'ไม่อนุมัติจากฝ่ายช่าง'
                                WHEN 'reject_manager_it_approve' THEN 'ไม่อนุมัติจากฝ่ายไอที'
                                WHEN 'reject_manager_cctv_approve' THEN 'ไม่อนุมัติจากฝ่ายไอที'
                                WHEN 'reject_manager_permission_approve' THEN 'ไม่อนุมัติจากฝ่ายไอที'
                                WHEN 'case_success' THEN 'งานเรียบร้อย / ผ่านการตรวจสอบ'
                                WHEN 'case_success_user' THEN 'งานเรียบร้อย / ผ่านการตรวจสอบจากผู้แจ้ง'
                                WHEN 'case_reject' THEN 'งานไม่เรียบร้อย / ไม่ผ่านการตรวจสอบ'
                                WHEN 'auto_close_case' THEN 'ปิดงานอัตโนมัติ'
                                WHEN 'auto_close_case_wait_recheck' THEN 'ผ่านการตรวจสอบงานอัตโนมัติจากระบบ'
                                ELSE cs.case_status
                            END
                        )
                    END
                ) AS case_status"),
                'cs.created_at AS case_open',
                'csh_manager.created_at AS sv_approve_date',
                'csh_manager_department.created_at AS manager_department_approve_date',
                DB::raw("CONCAT(br.branch_name, ' (', br.branch_code, ')') AS case_open_branch"),
                'cm.category_main_name',
                'ct.category_type_name',
                'cd.category_detail_name',
                'ci.category_item_name',
                'cl.category_list_name',
                'cs.sla',
                DB::raw("CONCAT(csh_check_user.created_at, ' , ', csh_check_user.case_detail) AS check_user_detail"),
                'cs.worker',
                'cs.checker',
                'cs.price',
                'cs.case_end',
                'cs.case_start',
            ]);
            $queryData = $queryData->get();

            if (isset($queryData) && count($queryData) > 0) {
                $data = [];

                foreach ($queryData as $key => $value) {
                    $workerDecoded = is_string($value->worker) ? json_decode($value->worker, true) : $value->worker;
                    $checkerDecoded = is_string($value->checker) ? json_decode($value->checker, true) : $value->checker;

                    $data[] = [
                        'ticket'        => $value->ticket,
                        'case_status'   => $value->case_status,
                        'case_open'     => $value->case_open,
                        'sv_approve_date'   => $value->sv_approve_date,
                        'manager_department_approve_date'   => $value->manager_department_approve_date,
                        'case_open_branch'  => $value->case_open_branch,
                        'category_main_name'    => $value->category_main_name,
                        'category_type_name'    => $value->category_type_name,
                        'category_detail_name'  => $value->category_detail_name,
                        'category_item_name'    => $value->category_item_name,
                        'category_list_name'    => $value->category_list_name,
                        'sla'           => $value->sla,
                        'check_user_detail' => $value->check_user_detail,
                        'worker'        => $workerDecoded,
                        'checker'       => $checkerDecoded,
                        'price'         => $value->price,
                        'case_end'      => $value->case_end,
                    ];
                }


                $returnData = [
                    'statusCode'    => 200,
                    'message'      => 'Data report retrieved successfully',
                    'data'         => $data
                ];
            } else {
                $returnData = [
                    'statusCode'    => 404,
                    'message'      => 'Data report retrieved not found',
                    'data'         => []
                ];
            }

            // dd($queryData);
        } catch (Exception $e) {
            Log::error("Function: " . get_class($this) . "::" . __FUNCTION__ . " Line: " . $e->getLine() . " Message: " . $e->getMessage());
            $returnData = [
                'statusCode'    => $e->getCode(),
                'message'      => 'Error occurred: ' . $e->getMessage(),
                'data'         => []
            ];
        } finally {
            return $returnData;
        }
    }
}
