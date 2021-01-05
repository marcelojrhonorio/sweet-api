<?php

namespace App\Http\Controllers\Stamp;

use App\Models\Stamp\Stamp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StampsController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['stamp_types'];

    public function __construct(Stamp $model)
    {
        $this->model = $model;
    }  
}