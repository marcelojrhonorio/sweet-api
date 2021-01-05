<?php

namespace App\Http\Controllers;

use App\Models\CustomerInvites;
use Illuminate\Http\Request;

class CustomerInvitesController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = [];

    public function __construct(CustomerInvites $model)
    {
        $this->model = $model;
    }
}
