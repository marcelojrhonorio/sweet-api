<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Customers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\MobileApp\AppMessage;
use App\Models\MobileApp\AppAllowedCustomer;

class UpdateCustomerPointsAppMobileJob extends Job
{
    private $timeout = 300;

    private $customerId;
    private $appAllowedCustomerId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appAllowedCustomerId, $customerId)
    {
        $this->customerId = $customerId;
        $this->appAllowedCustomerId = $appAllowedCustomerId;
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
            $cont = 0;

            $appMessage = AppMessage::where('customers_id', $this->customerId)
                                    ->orderByDesc('created_at')
                                    ->limit(5)
                                    ->get(); 

            foreach($appMessage as $message) {
                if(null != $message->opened_at) {
                    $cont++;
                }               
            }           

            if((count($appMessage) == 5) && ($cont == count($appMessage))) 
            {
                //update customer points
                $customer->points = $customer->points + 60;
                $customer->update();

                //update won_points in sweet.app_allowed_customers
                $allowed = AppAllowedCustomer::find($this->appAllowedCustomerId) ?? null;

                if($allowed) {
                    $allowed->won_points = Carbon::now()->toDateTimeString();
                    $allowed->update();
                }

                Log::debug('[APP_MOBILE] Usuário ' . $this->customerId . ' ganhou 60 pontos.');
            }            
        }
    }
}
