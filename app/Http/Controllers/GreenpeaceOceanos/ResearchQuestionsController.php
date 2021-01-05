<?php

namespace App\Http\Controllers\GreenpeaceOceanos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GreenpeaceOceanos\ResearchQuestion;

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
