<?php

namespace App\Http\Controllers\MobileApp\Indications;

use DB;
use Log;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MobileApp\AppValidatedIndication;

class AppValidatedIndicationController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['customer', 'indicated'];
    
    public function __construct(AppValidatedIndication $model)
    {
        $this->model = $model;
    }    
}
