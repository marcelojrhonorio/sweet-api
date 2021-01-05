<?php

namespace App\Jobs;

use Log;
use App\Models\Customers;
use App\Jobs\UpdateCustomerByCepJob2;

class UpdateCustomerByCepJob1 extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customers = Customers::where('deleted_at', null)
            ->where('updated_by_cep', 0)
            ->orderBy('id', 'DESC')
            ->take(2000)
            ->get();

        foreach($customers as $customer){
            $job = (new UpdateCustomerByCepJob2($customer->id, $customer->cep))->onQueue('verify_customer_by_cep_2');
            dispatch($job);
        }
    }
}
