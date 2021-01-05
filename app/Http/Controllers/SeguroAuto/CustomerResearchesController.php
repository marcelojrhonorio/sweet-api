<?php

namespace App\Http\Controllers\SeguroAuto;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SeguroAuto\CustomerResearches;

class CustomerResearchesController extends Controller
{
    //
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['customer'];

    public function __construct(CustomerResearches $model)
    {
        $this->model = $model;
    }

}
