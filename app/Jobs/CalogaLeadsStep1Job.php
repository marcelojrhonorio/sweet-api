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

class CalogaLeadsStep1Job extends Job
{
    use FixMailDomain;
    public $timeout = 5000;
    
    public function handle()
    {
        Log::debug('CalogaLeadsStep1Job started!');
        
        $yesterday = Carbon::now()->subDay();
        Log::debug("Recuperando os usuarios dos dia anterior -> ".$yesterday->toDateString());
        
        $customers = Customers::where(DB::raw("STR_TO_DATE(created_at,'%Y-%m-%d')"), '=', $yesterday->toDateString())
        ->where('confirmed', 0)
        ->where('allin_bounced',0)
        ->where('allin_send_empty',0)
        ->where('allin_not_send',0)
        ->whereRaw('ip_address is not null')
        ->where('caloga_send_status',0)
        ->whereNull('caloga_send_at')
        ->whereNull('allin_send_at')
        ->get();
        
        Log::debug("Total de custormers a serem processados! -> ".count($customers));
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

            // Dispatch job.
            $job =( new CalogaLeadsStep2Job($customer->id))->onQueue('sweetbonus_caloga_leads_2');
            dispatch($job);

        }
        
        Log::debug('CalogaLeadsStep1Job finished!');
    }

    private static function allowedCalogaBirthdate ($birthdate)
    {
        $years = Carbon::parse($birthdate)->age;

        if ($years >= 25) {
            return true;
        }

        return false;
    }

    private static function splitName($fullname)
    {
        $names = explode(' ', $fullname);

        $firstname = $names[0];

        unset($names[0]);

        $lastname = join(' ', $names);

        return [$firstname, $lastname];
    }
}
