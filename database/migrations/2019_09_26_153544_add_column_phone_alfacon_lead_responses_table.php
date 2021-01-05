<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPhoneAlfaconLeadResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_ALFACON', 'alfacon_mysql'))->table('lead_responses', function (Blueprint $table) {            
            $table->string('phone')->after('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_CONNECTION_ALFACON', 'alfacon_mysql'))->table('lead_responses', function (Blueprint $table) {            
            $table->dropColumn('phone');
        });
    }
}
