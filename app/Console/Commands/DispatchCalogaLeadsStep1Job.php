<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CalogaLeadsStep1Job;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class DispatchCalogaLeadsStep1Job extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'caloga:dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch caloga leads step one job';

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
        $job = new CalogaLeadsStep1Job;

        Queue::pushOn('sweetbonus_caloga_leads_1', $job);
    }
}
