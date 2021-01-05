<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use App\Jobs\DispatchInviteAppJob;
use App\Models\MobileApp\AppWaitingList;

class DispatchInviteApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invite-app:dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch invite app.';

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
        /*
        $appWaitingLists = AppWaitingList::whereNull('deleted_at')->get();

        $data = [];

        foreach ($appWaitingLists as $appWaitingList) 
        {            
            $data =
                DB::select("
                        select 
                        c.id AS `id`,
                        c.id AS `panel_id`,
                        c.fullname AS `fullname`,
                        SUBSTRING_INDEX(c.fullname, ' ', 1) AS `name`,
                        c.email AS `email`,
                        c.gender AS `gender`,
                        ROUND((TO_DAYS(CURDATE()) - TO_DAYS(c.birthdate)) / 365, 0) AS `age`,
                        c.state AS `state`
                    from 
                        sweet.customers c 
                    inner join 
                        sweet.customer_devices cd
                    on 
                        c.id = cd.customers_id
                    where 
                        cd.platform_family like '%Android%' and
                        c.id = " . $appWaitingList->customers_id ?? null );

            if(isset($data[0]->email)){
                echo $data[0]->email . "\n";        

                $job = (new DispatchInviteAppJob($data[0], 'waiting_list'))->onQueue('invite_app');
                dispatch($job);  
            }  
        }
        */

        $users = DB::select(
                    "select distinct
                        c.id AS `id`,
                        c.id AS `panel_id`,
                        c.fullname AS `fullname`,
                        SUBSTRING_INDEX(c.fullname, ' ', 1) AS `name`,
                        c.email AS `email`,
                        c.gender AS `gender`,
                        ROUND((TO_DAYS(CURDATE()) - TO_DAYS(c.birthdate)) / 365, 0) AS `age`,
                        c.state AS `state`
                    from 
                        sweet.customers c 
                    inner join 
                        sweet.app_waiting_list wl
                    on 
                        c.id = wl.customers_id
                    where 
                        wl.deleted_at is null");

        foreach ($users as $user) {          
            $job = (new DispatchInviteAppJob($user, 'waiting_list'))->onQueue('invite_app'); 
            dispatch($job);  
        }       

        echo  "Serão enviados " . count($users) . " emails. \n";

    }
}
