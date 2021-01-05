<?php

namespace App\Http\Controllers\Researches;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Researches\MiddlePage;

class MiddlePageController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    
    public function __construct(MiddlePage $model)
    {
        $this->model = $model;
    }
}