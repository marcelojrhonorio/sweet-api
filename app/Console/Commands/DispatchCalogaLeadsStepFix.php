<?php

namespace App\Console\Commands;

use App\Jobs\CalogaLeadsStepFixJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

class DispatchCalogaLeadsStepFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'caloga:dispatchFix {date}';

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
        $job = new CalogaLeadsStepFixJob($this->argument('date'));
        Queue::pushOn('sweetbonus_caloga_leads_fix', $job);
    }
}
