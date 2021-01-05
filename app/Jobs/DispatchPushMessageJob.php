<?php

namespace App\Jobs;

use Log;
use App\Models\Customers;
use App\Traits\GetAppMessageTrait;
use App\Models\MobileApp\AppMessage;
use App\Models\MobileApp\AppMessageType;

class DispatchPushMessageJob extends Job
{
    use GetAppMessageTrait;

    private $messageId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('[SSI] dentro da job do push');

        $message = AppMessage::find($this->messageId) ?? null;

       if(false === isset($message->id) || (null === $message->id)){
           Log::debug("[APP_PUSH] Mensagem não encontrada.");
           return;
       } 
       
       $type = AppMessageType::find($message->message_types_id);       

       if(false === isset($type->id) || (null === $type)){
            Log::debug("[APP_PUSH] Tipo não encontrado.");
            return;
        } 

        if(null !== $message->opened_at){
            Log::debug("[APP_PUSH] Mensagem já lida. Não será enviada.");
            return;           
        }

        $customer = Customers::find($message->customers_id) ?? null;

        if(false === isset($customer->id) || (null === $customer)){
            Log::debug("[APP_PUSH] Usuário não encontrado.");
            return;
        } 

        if(null === $customer->onesignal_id){
            Log::debug("[APP_PUSH] OneSignalId não encontrado.");
            return;
        } 

        $oneSignalData = [
            'app_id' => '5e596715-7eb0-47a1-85e6-27cb19f81255',
            'headings' => [
                'pt' => self::replaceStringVariables($message->customers_id, $type->push_title),
            ],
            'contents' => [
                'en' => self::replaceStringVariables($message->customers_id, $type->push_text),
                'pt' => self::replaceStringVariables($message->customers_id, $type->push_text),
            ],
            'android_accent_color' => '0060c6c5',
            'data' => [
                'message_text' => self::replaceStringVariables($message->customers_id, $type->text),
                'link' => $message->link,
                'image' => $type->image_path,
                'message_id' => (string) $message->id,
                'customers_id' => (string) $customer->id,
            ],
            'include_player_ids' => [$customer->onesignal_id],
        ];

        $fields = json_encode($oneSignalData);
        
        Log::info(print_r($fields, true));
            
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);   

        $message->response_onesignal_api = $response;
        $message->update();    

        Log::debug('[SSI] depois da job do push');

        curl_close($ch);
       
    }
}
