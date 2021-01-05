<?php

namespace App\Http\Controllers\IncentiveEmails;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IncentiveEmails\CheckinIncentiveEmail;

class CheckinIncentiveEmailsController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['customers', 'incentive_emails'];    

    public function __construct(CheckinIncentiveEmail $model)
    {
        $this->model = $model;
    }
}
