<?php

namespace App\Http\Controllers\Customers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CustomerAddress\CustomerAddress;

class CustomerAddressController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['customer'];
    
    public function __construct(CustomerAddress $model)
    {
        $this->model = $model;
    }    
}
