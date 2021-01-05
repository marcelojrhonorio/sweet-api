<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Jobs\ImportAddressFromExchangeJob;

class ImportAddressFromExchange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:import-address-exchange';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import address from customer_exchanged_points table.';

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
        $exchanges = 
            DB::select("SELECT DISTINCT 
                sweet.customer_exchanged_points.id as exchange_id
                FROM sweet.customers INNER JOIN sweet.customer_exchanged_points ON 
                sweet.customers.id = sweet.customer_exchanged_points.customers_id
                WHERE sweet.customer_exchanged_points.status_id = 7
                    AND sweet.customer_exchanged_points.city IS NOT NULL
                    AND sweet.customer_exchanged_points.state IS NOT NULL");       

        foreach ($exchanges as $exchange) {
            $job = (new ImportAddressFromExchangeJob($exchange->exchange_id))->onQueue('update_customer_address');
            dispatch($job);
        }
        
    }
}
