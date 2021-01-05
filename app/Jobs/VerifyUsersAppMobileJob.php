<?php

namespace App\Jobs;

use Log;
use App\Models\MobileApp\AppMessage;
use App\Models\MobileApp\AppAllowedCustomer;

class VerifyUsersAppMobileJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $timeout = 300;

    private $customerId;

    public function __construct($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cont = 0;

        $appMessage = AppMessage::where('customers_id', $this->customerId)
                                    ->orderByDesc('created_at')
                                    ->limit(5)
                                    ->get();        
        
        foreach($appMessage as $message) {
            if (preg_match('/erro/', $message->response_onesignal_api)) {
                $cont++;
            }               
        }     

        if((count($appMessage) == 5) && ($cont == count($appMessage))) {
            $allowedCustomer = AppAllowedCustomer::where('customers_id', $this->customerId)->first();
            $allowedCustomer->delete();
            
            Log::debug('[APP_MOBILE] Usuário ' . $this->customerId . ' deletado de app_allowed_customers.');
        }
    }
}
