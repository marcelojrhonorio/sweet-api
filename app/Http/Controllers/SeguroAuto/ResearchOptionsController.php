<?php

namespace App\Http\Controllers\SeguroAuto;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SeguroAuto\ResearchOption;

class ResearchOptionsController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['research_question'];
    
    public function __construct(ResearchOption $model)
    {
        $this->model = $model;
    } 
}
