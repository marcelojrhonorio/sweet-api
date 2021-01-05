<?php

namespace App\Console\Commands;

use DB;
use Log;
use App\Models\Customers;
use Illuminate\Console\Command;
use App\Jobs\VerifyAppIndicationJob;
use App\Models\MobileApp\AppMessage;
use App\Models\MobileApp\AppAllowedCustomer;
use App\Models\MobileApp\AppValidatedIndication;

class VerifyAppIndication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:app-mobile-indication';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check app mobile indications';

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
        $users = DB::select("select customers_id as id FROM sweet.app_indications");
       
        foreach($users as $user) 
        {
            $indicated = Customers::where("app_indicated_by", $user->id)->get() ?? null;            

            foreach ($indicated as $indic) 
            {
                //verificar se usuário baixou o app
                $status_downloaded = self::verifyAllowedCustomers($indic->id);

                if($status_downloaded) {

                    //verificar se usuário abriu as 5 últimas mensagens
                    $status_message = self::verifyAppMessages($indic->id);

                    if($status_message) {

                        //verificar `app_validated_indications`
                        $status_validated = self::verifyAppValidatedIndications($user->id, $indic->id);

                        if(is_null($status_validated)) {
                            $job = (new VerifyAppIndicationJob($user->id, $indic->id))->onQueue('verify_app_mobile_indication');
                            dispatch($job);  
                        }                        
                    } 
                }                
            }                             
        }   
    }

    private static function verifyAppValidatedIndications($customers_id, $indicated_id)
    {
        $appValidatedIndication = AppValidatedIndication::where('customers_id', $customers_id)
                                                        ->where('indicated_id', $indicated_id)
                                                        ->first() ?? null;                                            
        
        return $appValidatedIndication;
    }
    
    private static function verifyAppMessages($customers_id)
    {
        $cont = 0;

        $appMessage = AppMessage::where('customers_id', $customers_id)
                                ->orderByDesc('created_at')
                                ->limit(5)
                                ->get(); 

        foreach($appMessage as $message) {
            if(null != $message->opened_at) {
                $cont++;
            }               
        }   

        if((count($appMessage) == 5) && ($cont == count($appMessage))) {
            return true;
        }

        return false;
    }

    private static function verifyAllowedCustomers($customers_id)
    {
        $allowed_customers = AppAllowedCustomer::where('customers_id', $customers_id)->first() ?? null;

        if($allowed_customers) {
            return true;
        }         

        return false;
    }
}
