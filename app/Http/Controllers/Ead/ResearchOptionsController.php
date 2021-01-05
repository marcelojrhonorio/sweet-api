<?php

namespace App\Http\Controllers\Ead;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ead\ResearchOption;

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
