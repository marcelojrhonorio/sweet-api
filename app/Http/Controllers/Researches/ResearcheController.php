<?php

namespace App\Http\Controllers\Researches;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Researches\Researche;
use App\Http\Controllers\Controller;
use App\Models\Researches\ResearcheQuestion;
use App\Models\Researches\ResearchesMiddlePage;

class ResearcheController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['question'];
    
    public function __construct(Researche $model)
    {
        $this->model = $model;
    }

    public function delete(int $id)
    {
        $research = Researche::find($id);

        $researchQuestions = ResearcheQuestion::all()->where('researches_id', $id);
        $researchMiddlePage = ResearchesMiddlePage::where('researches_id', $id)->first();

        if (!empty($researchQuestions)) {
            foreach ($researchQuestions as $researchQuestion) {
                $researchQuestion->delete();
            }
        }

        if (!empty($researchMiddlePage)) {
            $researchMiddlePage->delete();
        }

        if (empty($research)) {
            return response()->json([
                'success' => false,
                'data'    => [],
            ], 404);
        }

        $research->delete();

        return response()->json([
            'success' => true,
            'data'    => $research,
        ]);
    }

    public function verifyUrl(string $url)
    {
        $research = Researche::where('final_url', $url)->first() ?? null;

        if($research) {
            return $research;
        }

        return null;
    }

    public function verify(Request $request)
    {
        /**
         *  Se tiver $research_id, é UPDATE. 
         */

        $url = $request->input('url');
        $research_id = $request->input('research_id');

        if($research_id) {
            $research1 = Researche::find($research_id) ?? null;
            $research2 = $this->verifyUrl($url);

            if($research2 && ($research1->id == $research2->id)) {              
                return null;
            }
            
            return $research2;
        }         
       
        $res = $this->verifyUrl($url);
        return $res;
    }
   
}