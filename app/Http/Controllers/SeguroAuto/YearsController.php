<?php

namespace App\Http\Controllers\SeguroAuto;

use App\Http\Controllers\Controller;
use App\Models\SeguroAuto\Years;

class YearsController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = [''];

    public function __construct(Years $model)
    {
        $this->model = $model;
    }
}
