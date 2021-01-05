<?php

namespace App\Console\Commands;

use Log;
use App\Models\Customers;
use Illuminate\Console\Command;
use App\Traits\GetAppMessageTrait;
use App\Models\MobileApp\AppMessage;
use App\Models\MobileApp\AppMessageType;

class DispatchPushMessage extends Command
{
    use GetAppMessageTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:dispatch {messageId?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch push message.';

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
       $messageId = $this->argument('messageId');
       $message = AppMessage::find($messageId) ?? null;

       if(false === isset($message->id) || (null === $message->id)){
           echo ("\nMensagem não encontrada.\n");
           return;
       } 
       
       $type = AppMessageType::find($message->message_types_id);       

       if(false === isset($type->id) || (null === $type)){
            echo ("\nTipo não encontrado.\n");
            return;
        } 

        if(null !== $message->opened_at){
            echo ("\nMensagem já lida. Não será enviada.\n");
            return;           
        }

        $customer = Customers::find($message->customers_id) ?? null;

        if(false === isset($customer->id) || (null === $customer)){
            echo ("\nUsuário não encontrado.\n");
            return;
        } 

        if(null === $customer->onesignal_id){
            echo ("\nOneSignalId não encontrado.\n");
            return;
        } 

        $oneSignalData = [
            'app_id' => '5e596715-7eb0-47a1-85e6-27cb19f81255',
            'headings' => [
                // 'pt' => self::replaceStringVariables($message->customers_id, $type->push_title),
                'pt' => str_replace("##nm_name##", explode(' ', $customer->fullname)[0], $type->push_title),
            ],
            'contents' => [
                // 'en' => self::replaceStringVariables($message->customers_id, $type->push_text),
                'en' => str_replace("##nm_name##", explode(' ', $customer->fullname)[0], $type->push_text),
                // 'pt' => self::replaceStringVariables($message->customers_id, $type->push_text),
                'pt' => str_replace("##nm_name##", explode(' ', $customer->fullname)[0], $type->push_text),
            ],
            'android_accent_color' => '0060c6c5',
            'data' => [
                // 'message_text' => self::replaceStringVariables($message->customers_id, $type->text),
                'message_text' => str_replace("##nm_name##", explode(' ', $customer->fullname)[0], $type->text),                
                // 'link' => $message->link,
                'link' => str_replace("##nm_id##", $customer->id, $message->link),
                'image' => $type->image_path,
                'message_id'  => (string) $message->id,
                'customers_id' => (string) $customer->id,
            ],
            'include_player_ids' => [$customer->onesignal_id],
        ];

        $fields = json_encode($oneSignalData);
            
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

        curl_close($ch);
    }
}
