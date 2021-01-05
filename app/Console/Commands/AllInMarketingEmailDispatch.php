<?php

namespace App\Console\Commands;

use App\Jobs\AllInInviteSsiProject2CreateMarkteingListJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\EventDispatcher\Tests\AbstractEventDispatcherTest;

class AllInMarketingEmailDispatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'allin:marketingemail {projectName}';

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
        //

        $job = new AllInInviteSsiProject2CreateMarkteingListJob($this->argument('projectName'));
        Queue::pushOn('api_dispatch_all_in_marketing_list', $job);
    }
}
