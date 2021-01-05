<?php

namespace App\Http\Controllers\Researches;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Researches\ResearchesMiddlePage;

class ResearchesMiddlePageController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['researche', 'middle_page', 'option', 'question'];
        
    public function __construct(ResearchesMiddlePage $model)
    {
        $this->model = $model;
    }

    public function getResearchMiddlePage(int $researches_id)
    {
        $researchesMiddlePage = ResearchesMiddlePage::where('researches_id', $researches_id)->get() ?? null;

        if($researchesMiddlePage) {
            return $researchesMiddlePage;
        }

        return null;
    }
}