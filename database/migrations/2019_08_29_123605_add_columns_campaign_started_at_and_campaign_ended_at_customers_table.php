<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsCampaignStartedAtAndCampaignEndedAtCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function($table) {
            $table->datetime('campaign_started_at')
                ->after('campaign')
                ->nullable();

            $table->datetime('campaign_ended_at')
                ->after('campaign_started_at')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function($table) {
            $table->dropColumn(['campaign_started_at', 'campaign_ended_at']);
        });
    }
}
