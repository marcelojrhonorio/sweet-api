<?php

namespace App\Http\Controllers\Researches;

use Illuminate\Http\Request;
use App\Models\Researches\Option;
use App\Http\Controllers\Controller;

class OptionController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    
    public function __construct(Option $model)
    {
        $this->model = $model;
    }
}