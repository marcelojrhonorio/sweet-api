<?php

namespace App\Http\Controllers\EmailForwarding;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailForwarding\EmailForwarding;

class EmailForwardingController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    
    public function __construct(EmailForwarding $model)
    {
        $this->model = $model;
    }  

    public function create(Request $request)
    {
        $emailForwarding = new EmailForwarding;
        $emailForwarding->save();

        return $emailForwarding;
    }
}
