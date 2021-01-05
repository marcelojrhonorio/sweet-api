<?php

namespace App\Http\Controllers\SeguroAuto;

use App\Http\Controllers\Controller;
use App\Models\SeguroAuto\ModelYears;

class ModelYearsController extends Controller
{

    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['vehicle_model', 'year'];

    public function __construct(ModelYears $model)
    {
        $this->model = $model;
    }
}
