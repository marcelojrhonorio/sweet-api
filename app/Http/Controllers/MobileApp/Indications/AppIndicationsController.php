<?php

namespace App\Http\Controllers\MobileApp\Indications;

use DB;
use Log;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MobileApp\AppIndication;

class AppIndicationsController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['customer'];
    
    public function __construct(AppIndication $model)
    {
        $this->model = $model;
    }    

    public function verifyIndicated(Request $request)
    {
        $customers_id = $request->input('customers_id');
        $app_indicated_by = $request->input('app_indicated_by'); 

        $customer = DB::select('SELECT (DATEDIFF(now(), sweet.customers.created_at)) as days_created FROM sweet.customers WHERE sweet.customers.id =' . $customers_id . ' AND sweet.customers.deleted_at IS NULL');
    
        $c = json_encode($customer);       
        $obj = json_decode($c);
           
        $aux = $obj[0];
        
        foreach ($aux as $a)
        {
            //atualizar 'app_indicated_by'
            if($a >= 15) {
                $customer = Customers::find($customers_id) ??  null;

                if(is_null($customer->app_indicated_by)) {
                    $customer->app_indicated_by = $app_indicated_by;
                    $customer->update();
                }                
            } 
        }

        return $customer;
    }
}
