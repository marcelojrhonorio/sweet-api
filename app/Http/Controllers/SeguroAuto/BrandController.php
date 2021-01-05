<?php

namespace App\Http\Controllers\SeguroAuto;

use App\Http\Controllers\Controller;
use App\Models\SeguroAuto\Brands;

class BrandController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['vehicle_models'];

    public function __construct(Brands $model)
    {
        $this->model = $model;
    }

}
