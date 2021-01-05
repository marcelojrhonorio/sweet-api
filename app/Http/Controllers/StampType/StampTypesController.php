<?php

namespace App\Http\Controllers\StampType;

use App\Models\Stamp\StampType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StampTypesController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;

    public function __construct(StampType $model)
    {
        $this->model = $model;
    }    
}
