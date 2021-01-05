<?php

namespace App\Http\Controllers\MemberGetMemberAction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MemberGetMemberAction\MemberGetMemberAction;

class MemberGetMemberActionController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['indicated_by', 'customer'];
    
    public function __construct(MemberGetMemberAction $model)
    {
        $this->model = $model;
    }    
}
