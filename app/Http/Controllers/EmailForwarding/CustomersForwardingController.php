<?php

namespace App\Http\Controllers\EmailForwarding;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailForwarding\CustomersForwarding;

class CustomersForwardingController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['customer'];
    
    public function __construct(CustomersForwarding $model)
    {
        $this->model = $model;
    }  

    public function create(Request $request)
    {
        $customers_id = $request->input('customers_id');
        $email_forwarding_id = $request->input('email_forwarding_id');

        $customersForwarding = new CustomersForwarding;
        $customersForwarding->customers_id = $customers_id;
        $customersForwarding->email_forwarding_id = $email_forwarding_id;
        $customersForwarding->save();

        return $customersForwarding;
    }
}
