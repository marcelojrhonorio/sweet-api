<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Jobs\CustomerCreatedJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DailyEmailConfirmationRecovery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:confirmation-recovery {RefDate?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recovery confirmation daily';

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
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now()->toDateTimeString();

        $dateOnly = (null === $this->argument('RefDate')) ? (string) explode(" ", $now)[0] : $this->argument('RefDate');

        $startDate = $dateOnly . " 00:00:00";
        $endDate   = $dateOnly . " 23:59:59";

        $customers = 
            DB::table('customers')
                ->whereNull('deleted_at')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where(function ($query) {
                    $query->where('allin_return_first_email', 'like', '%Erro%')
                          ->orWhereNull('allin_return_first_email');
                })->get();

        $this->info(count($customers) . " preparados para serem enviados <<" . $startDate . ">> - <<" . $endDate . ">>");
        
        Log::debug(count($customers) . " preparados para serem enviados <<" . $startDate . ">> - <<" . $endDate . ">>");
        
        $this->info("Processando...");

        foreach ($customers as $customer) {
            $job = (new CustomerCreatedJob($customer))->onQueue('confirmation_recovery');
            dispatch($job);
        }

        $this->info("Todos os disparos agendados :D");

        Log::debug("Todos os disparos agendados :D");

    }
}
