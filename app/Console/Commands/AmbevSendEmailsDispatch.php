<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendAmbevEmailsJob;
use App\Models\Ambev\AmbevCustomer;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\EventDispatcher\Tests\AbstractEventDispatcherTest;

class AmbevSendEmailsDispatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ambev:sendemail {ambevCustomerId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ambevCustomer = AmbevCustomer::find($this->argument('ambevCustomerId'));
        $job = (new SendAmbevEmailsJob($ambevCustomer))->onQueue('ambev_send_single_email');
        dispatch($job);
    }
}
