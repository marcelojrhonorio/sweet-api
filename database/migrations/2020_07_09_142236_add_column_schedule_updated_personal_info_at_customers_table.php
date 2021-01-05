<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnScheduleUpdatedPersonalInfoAtCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function($table) {
            $table->timestamp('schedule_updated_personal_info_at')->nullable()->default(env('START_SCHEDULE_UPDATE_INFO'))->after('updated_personal_info_at');
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
            $table->dropColumn('schedule_updated_personal_info_at');
        });
    }
}
