<?php

namespace App\Http\Controllers\Exchange;

use Log;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Exchange\CustomerExchangedPoint;

class CustomerExchangedPointsController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['customer', 'product_service'];
    
    public function __construct(CustomerExchangedPoint $model)
    {
        $this->model = $model;
    }  
    
    public function getLastExchange(Request $request)
    {
        $customers_id = $request->input('customers_id');

        $exchange = CustomerExchangedPoint::where('customers_id', $customers_id)
                                          ->orderByDesc('created_at')
                                          ->limit(1)
                                          ->get() ?? null;      

        //if finish
        if((!isset($exchange[0])) || (isset($exchange[0]) && (7 == $exchange[0]->status_id)) || (isset($exchange[0]) && (8 == $exchange[0]->status_id))){
            return 'true';
        } 

        return 'false';       
    }
}
