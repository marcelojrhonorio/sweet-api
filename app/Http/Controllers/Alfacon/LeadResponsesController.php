<?php

namespace App\Http\Controllers\Alfacon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Alfacon\LeadResponse;

class LeadResponsesController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    
    public function __construct(LeadResponse $model)
    {
        $this->model = $model;
    }
}
