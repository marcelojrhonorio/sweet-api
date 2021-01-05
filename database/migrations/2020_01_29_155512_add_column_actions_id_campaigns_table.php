<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnActionsIdCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->integer('actions_id')->after('desktop')->nullable()->unsigned();
            $table->foreign('actions_id')->references('id')->on('actions');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropForeign('campaigns_actions_id_foreign');
            $table->dropColumn('actions_id');
        });
    }
}
