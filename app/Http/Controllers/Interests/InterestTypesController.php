<?php

namespace App\Http\Controllers\Interests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Interests\InterestType;

class InterestTypesController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    
    public function __construct(InterestType $model)
    {
        $this->model = $model;
    }  
}
