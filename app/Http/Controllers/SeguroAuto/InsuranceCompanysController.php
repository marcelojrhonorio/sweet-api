<?php

namespace App\Http\Controllers\SeguroAuto;

use App\Http\Controllers\Controller;
use App\Models\SeguroAuto\InsuranceCompanys;

class InsuranceCompanysController extends Controller
{

    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['customer_research_answers'];

    public function __construct(InsuranceCompanys $model)
    {
        $this->model = $model;
    }
}
