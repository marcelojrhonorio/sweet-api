<?php
namespace App\Http\Controllers\Ssi;

use App\Http\Controllers\Controller;
use App\Models\Ssi\SsiProjectRespondent;
use App\Models\Ssi\SsiProject;

class SsiProjectsController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = [];

    public function __construct(SsiProject $model)
    {
        $this->model = $model;
    }
}
