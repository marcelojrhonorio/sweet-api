<?php

namespace App\Http\Controllers\Alfacon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Alfacon\ResearchOption;

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
