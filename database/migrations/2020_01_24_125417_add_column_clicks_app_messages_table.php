<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnClicksAppMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_messages', function (Blueprint $table) {
            $table->integer('clicks')->after('message_types_id')->unsigned()->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_messages', function (Blueprint $table) {
            $table->dropColumn('clicks');
        });
    }
}
