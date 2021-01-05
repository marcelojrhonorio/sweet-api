<?php

namespace App\Http\Controllers\SocialClass;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SocialClass\ResearchQuestion;

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
