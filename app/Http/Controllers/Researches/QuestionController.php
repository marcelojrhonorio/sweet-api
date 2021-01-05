<?php

namespace App\Http\Controllers\Researches;

use Illuminate\Http\Request;
use App\Models\Researches\Question;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['question_option'];
    
    public function __construct(Question $model)
    {
        $this->model = $model;
    }
    
}