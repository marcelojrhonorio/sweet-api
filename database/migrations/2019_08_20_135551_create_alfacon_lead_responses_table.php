<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlfaconLeadResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_ALFACON', 'alfacon_mysql'))->create('lead_responses', function (Blueprint $table) {            
            $table->increments('id');
            $table->string('fullname');
            $table->string('email');
            $table->string('site_origin');
            $table->string('response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_CONNECTION_ALFACON', 'alfacon_mysql'))->drop('lead_responses');
    }
}
