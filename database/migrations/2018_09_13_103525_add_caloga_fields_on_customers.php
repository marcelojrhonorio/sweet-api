<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCalogaFieldsOnCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('customers', function (Blueprint $table) {
            $table->boolean('allin_bounced')->unsigned()->nullable()->default(0)->after('indicated_by');
            $table->boolean('allin_bad_domain')->unsigned()->nullable()->default(0)->after('allin_bounced');
            $table->boolean('allin_send_empty')->unsigned()->nullable()->default(0)->after('allin_bad_domain');
            $table->boolean('allin_not_send')->unsigned()->nullable()->default(0)->after('allin_send_empty');
            $table->date('allin_send_at')->nullable()->after('allin_not_send');
            $table->integer('caloga_send_status')->unsigned()->nullable()->default(0)->after('allin_send_at');
            $table->date('caloga_send_at')->nullable()->after('caloga_send_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['caloga_send_at','caloga_send_status','allin_send_at','allin_not_send','allin_send_empty','allin_bad_domain','allin_bounced']);
        });
    }
}
