<?php

namespace App\Http\Controllers\SeguroAuto;

use App\Http\Controllers\Controller;
use App\Models\SeguroAuto\VehicleTypes;

class VehicleTypesController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['vehicle_models'];

    public function __construct(VehicleTypes $model)
    {
        $this->model = $model;
    }
}
