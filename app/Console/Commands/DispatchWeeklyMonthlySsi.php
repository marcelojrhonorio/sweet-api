<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DispatchWeeklyMonthlySsi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ssi:weekly-monthly-invites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch weekly and monthly SSI invites';

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
        Log::debug('weekly and monthly SSI dispatch');
    }
}