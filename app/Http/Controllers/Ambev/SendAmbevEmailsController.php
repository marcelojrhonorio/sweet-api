<?php

namespace App\Http\Controllers\Ambev;

use DB;
use Illuminate\Http\Request;
use App\Jobs\GetAmbevEmailsJob;
use App\Models\Ambev\AmbevCustomer;
use App\Http\Controllers\Controller;

class SendAmbevEmailsController extends Controller
{
    public function send()
    {
        $job = (new GetAmbevEmailsJob())->onQueue('ambev_get_emails');
        dispatch($job);

        return 'success!';
    }
}
