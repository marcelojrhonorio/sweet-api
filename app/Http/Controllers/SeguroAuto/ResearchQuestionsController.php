<?php

namespace App\Http\Controllers\SeguroAuto;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SeguroAuto\ResearchQuestion;

class ResearchQuestionsController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['research_options'];
    
    public function __construct(ResearchQuestion $model)
    {
        $this->model = $model;
    }
}
