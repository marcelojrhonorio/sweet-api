<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CustomerExpiredPoint;

class CustomerExpiredPointsController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['expired_points_customer'];
    
    public function __construct(CustomerExpiredPoint $model)
    {
        $this->model = $model;
    }
}