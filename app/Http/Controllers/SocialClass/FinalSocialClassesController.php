<?php

namespace App\Http\Controllers\SocialClass;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SocialClass\FinalSocialClass;

class FinalSocialClassesController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['customer'];
    
    public function __construct(FinalSocialClass $model)
    {
        $this->model = $model;
    }
}
