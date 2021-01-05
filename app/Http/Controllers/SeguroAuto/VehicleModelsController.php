<?php

namespace App\Http\Controllers\SeguroAuto;

use App\Http\Controllers\Controller;
use App\Models\SeguroAuto\VehicleModels;

class VehicleModelsController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['vehicle_type', 'brand', 'years'];

    public function __construct(VehicleModels $model)
    {
        $this->model = $model;
    }
}
