<?php

namespace App\Http\Controllers\Stamp;

use Illuminate\Http\Request;
use App\Models\Stamp\CustomerStamp;
use App\Http\Controllers\Controller;

class CustomerStampsController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['stamp', 'stamp_customers'];

    public function __construct(CustomerStamp $model)
    {
        $this->model = $model;
    }
}