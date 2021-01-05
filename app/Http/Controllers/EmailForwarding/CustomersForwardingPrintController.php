<?php

namespace App\Http\Controllers\EmailForwarding;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailForwarding\CustomersForwardingPrint;

class CustomersForwardingPrintController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['customer_forwarding'];
    
    public function __construct(CustomersForwardingPrint $model)
    {
        $this->model = $model;
    }  

    public function create(Request $request)
    {
        $customers_forwarding_id = $request->input('customers_forwarding_id');
        $image = $request->input('image');

        $customersForwardingPrint = new CustomersForwardingPrint;
        $customersForwardingPrint->customers_forwarding_id = $customers_forwarding_id;
        $customersForwardingPrint->image = $image;
        $customersForwardingPrint->save();

        return $customersForwardingPrint;
    }
}
