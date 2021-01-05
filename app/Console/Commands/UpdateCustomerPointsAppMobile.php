<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Jobs\UpdateCustomerPointsAppMobileJob;

class UpdateCustomerPointsAppMobile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:update-points-app-mobile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update customer points from App Mobile.';

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
        $datas = DB::select("SELECT id, customers_id FROM sweet.app_allowed_customers WHERE won_points IS NULL AND deleted_at IS NULL");
        
        foreach($datas as $data) {
            $job = (new UpdateCustomerPointsAppMobileJob($data->id, $data->customers_id))->onQueue('update_customer_points_app_mobile');
            dispatch($job);                   
        }    
    }
}
