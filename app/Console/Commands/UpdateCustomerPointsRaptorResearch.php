<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Jobs\UpdateCustomerPointsRaptorResearchJob;

class UpdateCustomerPointsRaptorResearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:update-points-raptor {begin} {end} {transactionId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update customer points from Raptor research.';

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
        $begin = $this->argument('begin');
        $end = $this->argument('end');
        $transactionId = $this->argument('transactionId');       

        $datas = 
            DB::select("SELECT id, customer_id FROM sweet.raptor_researches 
                where (created_at BETWEEN  '". $begin ."' AND '". $end ."') 
                and transaction_id = '". $transactionId ."' and research_type = 1 and won_points is null");        

        foreach ($datas as $data) 
        {
            $job = (new UpdateCustomerPointsRaptorResearchJob($data->id, $data->customer_id))->onQueue('update_customer_points_raptor');
            dispatch($job);            
        }

        echo ("\n[RAPTOR|". $transactionId ."] " . count($datas) . " usuários terão a pontuação atualizada.");
        
        if(count($datas) > 0) {
            echo ("\n[RAPTOR|". $transactionId ."] Todas as jobs foram agendadas.\n");
        } else {
            echo ("\n[RAPTOR|". $transactionId ."] Não há usuários para atualização de pontos.\n");
        }
        
    }
}
