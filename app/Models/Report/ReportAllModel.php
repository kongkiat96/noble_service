<?php

namespace App\Models\Report;

use App\Models\Master\getDataMasterModel;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportAllModel extends Model
{
    use HasFactory;
    private $getDataMasterModel;

    public function __construct()
    {
        $this->getDataMasterModel = new getDataMasterModel();
    }

    public function getDataReport($parameter, $type)
    {
        try {
            // dd($parameter);
            $type = decrypt($type);
            $setTypeIn = ($type == 'it') ? ['IT', 'permission', 'cctv'] : ['MT'];

            $query = DB::connection('mysql')->table('tbt_case_service AS cs')
                ->leftJoin('tbm_category_main AS cm', 'cs.category_main', '=', 'cm.id')
                ->leftJoin('tbm_category_type AS ct', 'cs.category_type', '=', 'ct.id')
                ->leftJoin('tbm_category_detail AS cd', 'cs.category_detail', '=', 'cd.id')
                ->leftJoin('tbm_category_item AS ci', 'cs.case_item', '=', 'ci.id')
                ->leftJoin('tbm_category_list AS cl', 'cs.case_list', '=', 'cl.id')

                // ->leftJoin('tbt_case_service_history AS csh_manager', function ($join) {
                //     $join->on('cs.id', '=', 'csh_manager.case_service_id')
                //         // ->whereColumn('csh_manager.case_status', DB::raw("CONCAT('manager_approve_', cs.use_tag)"));
                //         ->whereIn('csh_manager.case_status', [
                //             DB::raw("CONCAT('manager_approve_', cs.use_tag)"),
                //             DB::raw("CONCAT('reject_manager_approve_', cs.use_tag)")
                //         ])->latest('csh_manager.created_at')->limit(1);
                //         // ->where('csh_manager.case_step', '!=', 'wait_manager_it_approve');
                // })
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
                    // ->whereIn('csh_manager_department.case_status', [
                    //     DB::raw("CONCAT('manager_', cs.use_tag, '_approve')"),
                    //     DB::raw("CONCAT('reject_manager_', cs.use_tag, '_approve')")
                    // ]);
                })
                ->leftJoin('tbt_case_service_history AS csh_check_user', function ($join) {
                    $join->on('cs.id', '=', 'csh_check_user.case_service_id')
                        ->whereIn('csh_check_user.case_status', ['case_success_user', 'auto_close_case', DB::raw("CONCAT('reject_manager_approve_', cs.use_tag)"), DB::raw("CONCAT('reject_manager_', cs.use_tag, '_approve')")]);
                })
                ->leftJoin('tbt_employee AS em', 'cs.employee_other_case', '=', 'em.ID')
                ->leftJoin('tbm_branch AS br', 'em.branch_id', '=', 'br.id')

                ->leftJoin('tbm_status_work AS sw', 'cs.case_status', '=', 'sw.ID')
                ->leftJoin('tbm_group_status AS gs', 'sw.group_status', '=', 'gs.id')

                ->where('cs.deleted', 0)
                // ->where('cs.id', '94')
                ->whereIn('cs.use_tag', $setTypeIn);

            if (!empty($parameter['start_date']) && !empty($parameter['end_date'])) {
                $query->whereBetween('cs.created_at', [$parameter['start_date'], $parameter['end_date']]);
            } elseif (!empty($parameter['start_date'])) {
                $query->where('cs.created_at', '>=', $parameter['start_date']);
            }

            if (!empty($parameter['category_main_id'])) {
                $query->where('cs.category_main', $parameter['category_main_id']);
            }
            if (!empty($parameter['category_type_id'])) {
                $query->where('cs.category_type', $parameter['category_type_id']);
            }
            if (!empty($parameter['category_detail'])) {
                $query->where('cs.category_detail', $parameter['category_detail']);
            }

            if ($parameter['case_status'] != '') {
                $query->where('cs.case_status', $parameter['case_status']);
            }

            switch ($parameter['status_ticket']) {
                case 'auto_close':
                    $query->where('cs.auto_close', 'Y');
                    break;
                case 'user_close':
                    $query->where('cs.auto_close', 'N')->where('cs.tag_user_approve', 'Y');
                    break;
                case 'wait_close':
                    $query->where('cs.auto_close', 'N')->where('cs.tag_user_approve', 'N')->where('gs.group_status_en', 'success');
                    break;
                // default:
                //     $query->where('cs.case_status', $parameter['status_ticket']);
                //     break;
            }

            $dataCount = (clone $query)->count();

            $query->select([
                'cs.id',
                'cs.ticket',
                'cs.case_status',
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
                'cs.case_start'
            ]);

            if ($parameter['start'] == 0) {
                $query->limit($parameter['length'])->orderByDesc('cs.created_at');
            } else {
                $query->offset($parameter['start'])
                    ->limit($parameter['length'])
                    ->orderByDesc('cs.created_at');
            }

            $data = $query->get();
            // dd($data);
            $newArr = $data->map(function ($value) {
                if (is_numeric($value->case_status)) {
                    $caseStatus = $this->getDataMasterModel->getStatusWorkForByID($value->case_status);
                    $mapStatus = $caseStatus['status_name'];
                    $mapColor = $caseStatus['status_color'];
                } else {
                    $caseStatus = $value->case_status ?? '-';
                    $mapStatus = $caseStatus;
                    $mapColor = '#e7e7ff';
                }

                if ($value->case_end != null && $value->sla != null) {
                    $calSLA = $this->getDataMasterModel->calculateSLA($value->sla, $value->case_start, $value->case_end);
                    $calSLA = $calSLA['message'];
                } else {
                    $calSLA = '-';
                }

                return [
                    'ticket' => $value->ticket,
                    'case_status' => $mapStatus,
                    'case_open' => $value->case_open,
                    'sv_approve_date' => !empty($value->sv_approve_date) ? $value->sv_approve_date : '-',
                    'manager_department_approve_date' => !empty($value->manager_department_approve_date) ? $value->manager_department_approve_date : '-',
                    'case_open_branch' => $value->case_open_branch,
                    'category_main_name' => $value->category_main_name,
                    'category_type_name' => $value->category_type_name,
                    'category_detail_name' => $value->category_detail_name,
                    'category_item_name' => !empty($value->category_item_name) ? $value->category_item_name : '-',
                    'category_list_name' => !empty($value->category_list_name) ? $value->category_list_name : '-',
                    'sla' => !empty($value->sla) ? $value->sla : '-',
                    'cal_sla'   => $calSLA,
                    'check_user_detail' => !empty($value->check_user_detail) ? $value->check_user_detail : '-',
                    'worker' => $value->worker ? implode(', ', array_map(function ($worker) {
                        return $worker->name;
                    }, json_decode($value->worker))) : '-',
                    'checker' => $value->checker ? implode(', ', array_map(function ($checker) {
                        return $checker->name;
                    }, json_decode($value->checker))) : '-',
                    'price' => !empty($value->price) ? $value->price : '-',
                ];
            })->toArray();

            $returnData = [
                'status' => 200,
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
}
