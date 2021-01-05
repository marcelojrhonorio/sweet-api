<?php

namespace App\Http\Controllers\Infoproduto;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Infoproduto\ResearchOption;

class ResearchOptionsController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['research_question'];
    
    public function __construct(ResearchOption $model)
    {
        $this->model = $model;
    }
}
