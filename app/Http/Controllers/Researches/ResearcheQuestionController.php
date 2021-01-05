<?php

namespace App\Http\Controllers\Researches;

use Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Researches\ResearcheQuestion;

class ResearcheQuestionController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['researche', 'question'];
        
    public function __construct(ResearcheQuestion $model)
    {
        $this->model = $model;
    }

    public function remove(int $id)
    {
        $researchQuestions = ResearcheQuestion::find($id) ?? null;
        $researchQuestions->ordering = null;
        $researchQuestions->update();

        $researchQuestions->delete();

        return response()->json([
            'success' => true,
            'data'    => $researchQuestions,
        ]);
    }

    public function delete(int $id)
    {
        $researchQuestions = ResearcheQuestion::all()->where('researches_id', $id);

        if (empty($researchQuestions)) {
            return response()->json([
                'success' => false,
                'data'    => [],
            ], 404);
        }

        foreach ($researchQuestions as $researchQuestion) {
            $researchQuestion->delete();
        }

        return response()->json([
            'success' => true,
            'data'    => $researchQuestions,
        ]);
    }

    public function getResearchQuestion($researches_id)
    {
        $researchQuestions = ResearcheQuestion::where('researches_id', $researches_id)->orderBy('ordering', 'ASC')->get() ?? null; 

        if($researchQuestions) {
            return $researchQuestions;
        }

        return null;
    }
}