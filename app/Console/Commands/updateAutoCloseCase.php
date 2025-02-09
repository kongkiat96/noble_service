<?php

namespace App\Console\Commands;

use App\Models\Auto\CloseCaseModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class updateAutoCloseCase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateAutoCloseCase:runscript
    {--updateAutoCloseCase : updateAutoCloseCase; run on 23.00}
        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Auto Close Case.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->line('Start batch on ' . Carbon::now() . ' --updateAutoCloseCase');
            $runDate = Carbon::now();
            $this->line('Process job on cycle date :' . $runDate);

            $runScriptAuto = new CloseCaseModel();
            $runScriptAuto->updateAutoCloseCase();

            $this->info('Job script Update Auto Close Case done');
            $this->line('Finished on ' . Carbon::now());
            return true;
        } catch (Exception $e) {
            // $a_return["status"] = "-1";
            // $a_return["message"] = $e->getMessage();
            // $a_return["data"] = array();
            $this->error('Fail to process job Main. - ' . $e->getMessage());
            return true;
        }
    }
}
