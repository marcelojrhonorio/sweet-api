<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Customers;
use Illuminate\Support\Facades\Log;
use App\Jobs\DispatchPushMessageJob;
use App\Models\MobileApp\AppMessage;
use App\Models\MobileApp\AppMessageType;
use App\Models\MobileApp\AppAllowedCustomer;

class SaveAppMessageService
{

    public static function createMessage(int $customerId, string $type, string $link)
    {
        $type = AppMessageType::where('title', $type)->get() ?? null;
        $customer = Customers::find($customerId) ?? null;

        if (false === isset($type[0]->title) || null === $type) {
            Log::debug('[SSI] não encontrou uma message_type com esse título.');
            return;
        }

        if (false === isset($customer->id) || null === $customer) {
            Log::debug('[SSI] não encontrou um customer com esse ID (' . $customer->id .')');
            return;
        } 
        
        $allowedCustomers = AppAllowedCustomer::where('customers_id', $customerId)->get() ?? null;

        if ((null === $allowedCustomers) || isset($allowedCustomers[0]->id)) {
            if($allowedCustomers[0]->access_expired_at > Carbon::now()->toDateTimeString()){                
                $message = new AppMessage();
                $message->customers_id = $customerId;
                $message->message_types_id = $type[0]->id;
                $message->link = '';
                $message->real_link = $link;
                $message->save();

                $message->link = env('STORE_URL') . '/app-messages/' . $message->id;
                $message->update();  

                Log::debug('[SSI] antes do envio do push');

                $job = (new DispatchPushMessageJob($message->id))->onQueue('app_push_message');
                dispatch($job);   
            }
        }

        Log::debug('[SSI] não existe allowed_customer com esse ID de customer ' . $customerId);

    }
}