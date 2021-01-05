<?php

namespace App\Http\Controllers\RelationshipRule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RelationshipRule\RelationshipRule;

class RelationshipRulesController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;
    
    protected $model;

    public function __construct(RelationshipRule $model)
    {
        $this->model = $model;
    }
}
