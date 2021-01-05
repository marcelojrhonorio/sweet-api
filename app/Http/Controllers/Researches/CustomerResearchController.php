<?php

namespace App\Http\Controllers\Researches;

use DB;
use Log;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Researches\ResearcheAnswer;
use App\Models\Researches\CustomerResearch;
use App\Models\Researches\ResearcheQuestion;

class CustomerResearchController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    
    public function __construct(CustomerResearch $model)
    {
        $this->model = $model;
    }

    public function verify(Request $request)
    {
        $researches_id = $request->input('researches_id');
        $customers_id = $request->input('customers_id');

        $researcheQuestion = null;
        $customerResearch = null;
        $researcheAnswer = null;
        $qtdAnsweredQuestions = [];

        $customer = Customers::find($customers_id) ?? null;

        if(!is_null($customer)) {
            $researcheQuestion = ResearcheQuestion::where('researches_id', '=', $researches_id)->get() ?? null;

            $customerResearch = CustomerResearch::where('researches_id', '=', $researches_id)->where('customers_id', '=', $customers_id)->first() ?? null;

            $researcheAnswer = ResearcheAnswer::where('customers_id', $customers_id)
                                        ->where('researches_id', $researches_id)
                                        ->orderByDesc('created_at')
                                        ->limit(1)
                                        ->get() ?? null;

            $qtdAnsweredQuestions = DB::select('SELECT DISTINCT sweet_researches.researche_answers.questions_id FROM sweet_researches.researche_answers WHERE customers_id=' . $customers_id . ' AND researches_id='. $researches_id) ?? null;
        }  

        if(!is_null($customerResearch)) {
            return response()->json([
                'status' => 'answered',
                'data' => $researcheAnswer,
                'qtdAnsweredQuestions' => count($qtdAnsweredQuestions),
                'qtdResearcheQuestion' => count($researcheQuestion),                
            ]);
        }

        if($researcheAnswer) {
            return response()->json([
                'status' => 'not_answered',
                'data' => $researcheAnswer,
                'qtdAnsweredQuestions' => count($qtdAnsweredQuestions),
                'qtdResearcheQuestion' => count($researcheQuestion),    
            ]);
        }

        return response()->json([
            'status' => 'not_answered',
            'data' => $researcheAnswer,
            'qtdAnsweredQuestions' => count($qtdAnsweredQuestions),
            'qtdResearcheQuestion' => $researcheQuestion ? count($researcheQuestion) : 0,    
        ]);
    }
}
