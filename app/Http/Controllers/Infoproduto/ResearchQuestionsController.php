<?php

namespace App\Http\Controllers\Infoproduto;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Infoproduto\ResearchQuestion;

class ResearchQuestionsController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['research_options'];
    
    public function __construct(ResearchQuestion $model)
    {
        $this->model = $model;
    }
}
