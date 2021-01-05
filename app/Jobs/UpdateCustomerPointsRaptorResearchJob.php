<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Customers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateCustomerPointsRaptorResearchJob extends Job
{
    private $timeout = 300;

    private $customerId;
    private $raptorResearchId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($raptorResearchId, $customerId)
    {
        $this->customerId = $customerId;
        $this->raptorResearchId = $raptorResearchId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = Customers::find($this->customerId) ?? null;

        if($customer) 
        {   
            //update customer points
            $customer->points = $customer->points + 100;
            $customer->update();

            //update won_points in sweet.raptor_researches
            DB::table('sweet.raptor_researches')->where('id', $this->raptorResearchId)->update(['won_points' => Carbon::now()->toDateTimeString()]);
        }
    }
}
