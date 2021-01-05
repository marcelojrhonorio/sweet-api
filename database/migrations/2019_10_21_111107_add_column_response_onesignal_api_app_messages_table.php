<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnResponseOnesignalApiAppMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_messages', function($table) {
            $table->string('response_onesignal_api')
                  ->nullable()
                  ->default(null)
                  ->after('opened_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_messages', function($table) {
            $table->dropColumn('response_onesignal_api');
        });
    }
}
