<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerDevice;
use App\Http\Controllers\Controller;

class CustomerDevicesController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['customer_device_customers'];
    
    public function __construct(CustomerDevice $model)
    {
        $this->model = $model;
    }
}