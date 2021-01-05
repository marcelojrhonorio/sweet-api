<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnsubscribedCustomer;

class UnsubscribedCustomersController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['unsubscribed_customer'];

    public function __construct(UnsubscribedCustomer $model)
    {
        $this->model = $model;
    }
}
