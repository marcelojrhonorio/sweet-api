<?php

namespace App\Http\Controllers\Quiz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Quiz\ResearchOption;

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
