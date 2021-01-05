<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRealLinkAppMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_messages', function (Blueprint $table) {
            $table->string('real_link')->after('link')->nullable(); 
            $table->unique(['customers_id', 'real_link']);         
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
            $table->dropColumn('real_link');
        });
    }
}
