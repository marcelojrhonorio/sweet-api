<?php

namespace App\Http\Controllers\Researches;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Researches\QuestionOption;

class QuestionOptionController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['question', 'option'];
        
    public function __construct(QuestionOption $model)
    {
        $this->model = $model;
    }

    public function getQuestionOption(int $questions_id)
    {
        $questionOption = QuestionOption::where('questions_id', $questions_id)->get() ?? null;

        if($questionOption) {
            return $questionOption;
        }

        return null;
    }

    public function getQuestionOptionByOption(int $options_id)
    {
        $questionOption = QuestionOption::where('options_id', $options_id)->first() ?? null;

        if($questionOption) {
            return $questionOption;
        }

        return null;
    }
}