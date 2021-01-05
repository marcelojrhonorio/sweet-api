<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Customers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Jobs\UpdateCustomerExpiredPoints;

class UpdateCustomerPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:zero-points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set points = 0 after 365 days.';

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
        $customerIds = 
            DB::select("SELECT id 
                FROM sweet.customers 
                WHERE (DATEDIFF(now(), created_at) >= 365)
                    AND deleted_at IS NULL
                    AND points IS NOT NULL
                    AND ((last_points_expiration_at IS NULL) OR (DATEDIFF(now(), last_points_expiration_at) >= 365))");

        foreach ($customerIds as $customerId) {
            $job = (new UpdateCustomerExpiredPoints($customerId))->onQueue('update_customer_expired_points');
            dispatch($job);
        }
        
    }
}
