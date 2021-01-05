<?php

namespace App\Jobs;

use DB;
use Illuminate\Bus\Queueable;
use App\Jobs\SendAmbevEmailsJob;
use Illuminate\Support\Facades\Log;
use App\Models\Ambev\AmbevCustomer;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class GetAmbevEmailsJob implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    public $timeout = 5000;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('Send Ambev Emails Started!');

        $ambevCustomers = DB::table('ambev_customers')
            ->where('fired_email', 0)
            ->where('answered', 0)
            ->get();

        Log::debug('Total de e-mails a serem enviados: ' . $ambevCustomers->count());

        foreach ($ambevCustomers as $ambevCustomer) {
            $job = (new SendAmbevEmailsJob($ambevCustomer))->onQueue('ambev_send_emails');
            dispatch($job);
        }

        Log::debug('Send Ambev Emails Finished!');
    }
}
