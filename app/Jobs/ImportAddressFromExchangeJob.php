<?php

namespace App\Jobs;

use Log;
use App\Models\Stamp\Stamp;
use App\Models\Stamp\CustomerStamp;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Exchange\CustomerExchangedPoint;
use App\Models\CustomerAddress\CustomerAddress;

class ImportAddressFromExchangeJob extends Job implements ShouldQueue
{
    private $timeout = 300;

    private $exchangeId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($exchange)
    {
       $this->exchangeId = (int) $exchange;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {        
        self::updateCustomerAddress($this->exchangeId);
    }

    private static function updateCustomerAddress($exchangeId)
    {        
        $customerExchangedPoint = CustomerExchangedPoint::find($exchangeId);
       
        $customerAddress = new CustomerAddress();
        $customerAddress->customers_id = $customerExchangedPoint->customers_id;
        $customerAddress->cep = $customerExchangedPoint->cep;        
        $customerAddress->street = $customerExchangedPoint->address;      
        $customerAddress->number = $customerExchangedPoint->number;  
        $customerAddress->reference_point = $customerExchangedPoint->reference_point;
        $customerAddress->neighborhood = $customerExchangedPoint->neighborhood;
        $customerAddress->city = $customerExchangedPoint->city;        
        $customerAddress->state = $customerExchangedPoint->state;    
        $customerAddress->save(); 

        $stamp = Stamp::where('type', 5)->first();        
        
        $customerStamp = new CustomerStamp();
        $customerStamp->customers_id = $customerExchangedPoint->customers_id;
        $customerStamp->stamps_id = $stamp->id;
        $customerStamp->count_to_stamp = 1;
        
        $customerStamp->save();  
    }
}
