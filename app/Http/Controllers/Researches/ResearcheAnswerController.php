<?php

namespace App\Http\Controllers\Researches;

use Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Researches\ResearcheAnswer;

class ResearcheAnswerController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['researche', 'question', 'option'];
    
    public function __construct(ResearcheAnswer $model)
    {
        $this->model = $model;
    }

    public function insertAnswers(Request $request)
    {
        $researcheAnswer = new ResearcheAnswer();
        $researcheAnswer->respondent = $request->input('respondent');
        $researcheAnswer->customers_id = $request->input('customers_id');
        $researcheAnswer->researches_id = $request->input('researches_id');
        $researcheAnswer->questions_id = $request->input('questions_id');
        $researcheAnswer->options_id = $request->input('options_id');
        $researcheAnswer->save();

        return $researcheAnswer;
    }

    public function updateAnswers(Request $request)
    {
        $researcheAnswers = ResearcheAnswer::where('customers_id', '=', $request->input('customers_id'))->where('researches_id', '=', $request->input('researches_id'))->get();

        if(1 != count($researcheAnswers)) {

            $researcheAnswer = ResearcheAnswer::where('customers_id', '=', $request->input('customers_id'))->where('researches_id', '=', $request->input('researches_id'))->where('questions_id', '=', $request->input('questions_id'))->first() ?? null;

            if(!is_null($researcheAnswer) && !($request->input('answer_is_array'))) {
                $researcheAnswer->options_id = $request->input('options_id');
                $researcheAnswer->update();

                foreach($researcheAnswers as $ra) 
                {
                    if($ra->questions_id != $request->input('questions_id')) {
                        $ra->delete();
                    }
                }

            } else {
                $researche_answer = new ResearcheAnswer();
                $researche_answer->respondent = $request->input('respondent');
                $researche_answer->customers_id = $request->input('customers_id');
                $researche_answer->researches_id = $request->input('researches_id');
                $researche_answer->questions_id = $request->input('questions_id');
                $researche_answer->options_id = $request->input('options_id');
                $researche_answer->save();
            }            

            

        } else {
            $researche_answer = new ResearcheAnswer();
            $researche_answer->respondent = $request->input('respondent');
            $researche_answer->customers_id = $request->input('customers_id');
            $researche_answer->researches_id = $request->input('researches_id');
            $researche_answer->questions_id = $request->input('questions_id');
            $researche_answer->options_id = $request->input('options_id');
            $researche_answer->save();

            return $researche_answer;
        }
    
        return $researcheAnswer;
    }
}