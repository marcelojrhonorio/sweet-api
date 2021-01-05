<?php

namespace App\Http\Controllers\IncentiveEmails;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IncentiveEmails\IncentiveEmail;

class IncentiveEmailsController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;

    public function __construct(IncentiveEmail $model)
    {
        $this->model = $model;
    }
}
