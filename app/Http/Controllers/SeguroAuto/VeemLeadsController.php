<?php

namespace App\Http\Controllers\SeguroAuto;

use App\Http\Controllers\Controller;
use App\Models\SeguroAuto\VeemLeads;

class VeemLeadsController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;

    public function __construct(VeemLeads $model)
    {
        $this->model = $model;
    }
}
