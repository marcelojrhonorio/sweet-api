<?php

namespace App\Jobs;

use DB;
use Carbon\Carbon;
use App\Models\Customers;
use App\Traits\FixMailDomain;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

class CalogaLeadsStepFixJob extends Job
{
    public $timeout = 5000;
    private $_date;

    /**
     * Create a new job instance.
     */
    public function __construct(string $date = null)
    {
        $this->_date = $date;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::debug('CalogaLeadsStepFix started!');

        $yesterday = Carbon::now()->subDay();
        Log::debug("Recuperando os usuarios dos dia anterior -> {$this->_date}");

        $customers = Customers::where(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), '=', $this->_date)
            ->where('confirmed', 1)
            // ->where('allin_not_send', 1)
            // ->where('allin_bounced', 0)
            ->whereRaw("(  caloga_api_return is null or caloga_api_return  = 'Error' ) ")
            ->whereRaw('ip_address is not null')
            ->whereRaw('ROUND((TO_DAYS(CURDATE()) - TO_DAYS(`sweet`.`customers`.`birthdate`)) / 365, 0) > 24')
            ->whereNull('caloga_send_at')
            ->get();

        Log::debug('Total de custormers a serem processados! -> '.count($customers));
        foreach ($customers as $customer) {
            $allowedBirthdate = self::allowedCalogaBirthdate($customer->birthdate);

            // Verifica se o e-mail é permitido.
            if ($this->isCalogaEmailBlocked($customer->email)) {
                continue;
            }

            // Menor de 25 anos.
            if (false === $allowedBirthdate) { 
                continue;
            }

            // Verifica se existe mais usuários com o mesmo IP.
            $customersByIp = Customers::where('ip_address', $customer->ip_address)->get();
            if (sizeof($customersByIp) > 5) {
                Log::debug('[CALOGA] o IP ' . $customer->ip_address . ' aparece ' . sizeof($customersByIp) . ' vezes. O lead não será enviado.');
                continue;
            }

            $splitedName = self::splitName($customer->fullname);
            
            // Verifica se o nome ou sobrenome é vazio.
            if (('' == $splitedName[0]) || ('' == $splitedName[1])) {
                continue;
            }
                        
            $job = ( new CalogaLeadsStep2Job($customer->id))->onQueue('sweetbonus_caloga_leads_2');
            dispatch($job);
        }

        Log::debug('CalogaLeadsStep1Job finished!');
    }
}
