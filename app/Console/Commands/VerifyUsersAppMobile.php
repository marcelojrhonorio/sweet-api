<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use App\Jobs\VerifyUsersAppMobileJob;

class VerifyUsersAppMobile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:users-app-mobile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if users are active in the app mobile';

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
        $users = DB::select("select distinct customers_id as id FROM sweet.app_messages");
        
        foreach($users as $user) {
            $job = (new VerifyUsersAppMobileJob($user->id))->onQueue('verify_users_app_mobile');
            dispatch($job);                   
        }        
    }
}
