<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnNotificationsIdAppMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_messages', function (Blueprint $table) {
            $table->integer('app_notifications_id')->after('message_types_id')->default(null)->unsigned()->nullable();
            $table->foreign('app_notifications_id')
                ->references('id')
                ->on('app_notifications');
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
            $table->dropForeign('app_messages_app_notifications_id_foreign');
            $table->dropColumn('app_notifications_id');
        });
    }
}
