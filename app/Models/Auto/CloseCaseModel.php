<?php

namespace App\Models\Auto;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CloseCaseModel extends Model
{
    use HasFactory;

    public function updateAutoCloseCase()
    {
        try {
            $caseTypes = [
                'IT' => ['IT', 'permission', 'cctv'],
                'MT' => ['MT']
            ];

            foreach ($caseTypes as $type => $tags) {
                $cases = $this->getAutoCloseCases($tags);
                $count = $cases->count(); // นับจำนวนรายการของแต่ละกลุ่ม

                // Log จำนวนรายการในกลุ่ม
                Log::channel('autoCloseCase')->info("Group: {$type}, Total Cases: {$count}");

                // Log รายละเอียดของแต่ละ case
                foreach ($cases as $case) {
                    Log::channel('autoCloseCase')->info("Ticket: " . $case->ticket);
                }
            }
            DB::statement("CALL auto_close_cases()");
            Log::channel('autoCloseCase')->info("Stored Procedure auto_close_cases() executed successfully.");

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    private function getAutoCloseCases(array $useTags)
    {
        return DB::connection('mysql')->table('tbt_case_service AS cs')
            ->leftJoin('tbm_status_work AS sw', function ($join) {
                $join->on('cs.case_status', '=', 'sw.id')
                    ->where('sw.status', '1')
                    ->where('sw.deleted', '0');
            })
            ->leftJoin('tbm_group_status AS gs', function ($join) {
                $join->on('sw.group_status', '=', 'gs.id')
                    ->whereIn('sw.status_use', [DB::raw('cs.use_tag'), 'all'])
                    ->where('gs.status_tag', '1')
                    ->where('gs.deleted', '0');
            })
            ->where('cs.deleted', '0')
            ->whereIn('cs.use_tag', $useTags)
            ->whereRaw('DATEDIFF(CURDATE(), cs.case_start) > ?', [1])
            ->where('cs.tag_user_approve', 'N')
            ->where('gs.group_status_en', 'success')
            ->where('cs.auto_close', 'N')
            ->select('cs.ticket')
            ->get();
    }
}
