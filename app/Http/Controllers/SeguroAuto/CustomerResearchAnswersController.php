<?php

namespace App\Http\Controllers\SeguroAuto;

use App\Http\Controllers\Controller;
use App\Models\SeguroAuto\CustomerResearchAnswers;

class CustomerResearchAnswersController extends Controller
{

    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = [];

    public function __construct(CustomerResearchAnswers $model)
    {
        $this->model = $model;
    }
}
