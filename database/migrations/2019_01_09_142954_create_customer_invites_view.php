<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerInvitesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $attach_databse = env('APP_ENV') === "testing" ? "ATTACH DATABASE ':memory:' AS sweet;" : null;
         DB::connection(env('DB_CONNECTION', 'mysql'))
              ->statement("{$attach_databse}CREATE VIEW v_customer_invites as 
                            select
                                spr.id as id,
                                concat(sp.starturlhead,
                                spr.starturlid,
                                '&sourcedata=',
                                spr.id) as invite,
                                spr.respondentId as customer_id,
                                spr.status,
                                spr.created_at,
                                spr.updated_at
                         	from
                                ssi_projects as sp
                            inner join ssi_project_respondents as spr on
                                spr.ssi_project_id = sp.id
                            order by
                                sp.created_at DESC");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        $dettach_databse = env('APP_ENV') === "testing" ? "DETACH DATABASE sweet;" : null;

        DB::connection(env('DB_CONNECTION', 'mysql'))->statement($dettach_databse . "DROP VIEW v_customer_invites");
    }
}
