<?php

namespace App\Http\Controllers\EmailForwarding;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailForwarding\CustomersForwardingEmail;

class CustomersForwardingEmailController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['customer_forwarding'];
    
    public function __construct(CustomersForwardingEmail $model)
    {
        $this->model = $model;
    }  

    public function create(Request $request)
    {
        $customers_forwarding_id = $request->input('customers_forwarding_id');
        $name = $request->input('name');
        $email = $request->input('email');

        $customersForwardingEmail = new CustomersForwardingEmail;
        $customersForwardingEmail->customers_forwarding_id = $customers_forwarding_id;
        $customersForwardingEmail->name = $name;
        $customersForwardingEmail->email = $email;
        $customersForwardingEmail->save();

        return $customersForwardingEmail;
    }    
}
