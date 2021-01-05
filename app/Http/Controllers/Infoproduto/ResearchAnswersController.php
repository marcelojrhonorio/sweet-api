<?php

namespace App\Http\Controllers\Infoproduto;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Infoproduto\ResearchAnswer;

class ResearchAnswersController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['research_question', 'research_option'];
    
    public function __construct(ResearchAnswer $model)
    {
        $this->model = $model;
    }
}
