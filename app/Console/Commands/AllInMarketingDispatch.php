<?php

namespace App\Console\Commands;

use App\Jobs\AllInInviteSsiProject1WithMarketingEmailJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

class AllInMarketingDispatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'allin:marketing {projectId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test AllMarketingCommand';

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
        $job = new AllInInviteSsiProject1WithMarketingEmailJob($this->argument('projectId'));

        Queue::pushOn('api_ssi_invite_project_all_marketing_email_1', $job);
    }
}
