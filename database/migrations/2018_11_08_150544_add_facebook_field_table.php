<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacebookFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('customers',function(Blueprint $table){
            $table->integer('facebook_id')->nullable()->after('last_password_request');
            $table->dateTime('facebook_sync_at')->nullable()->after('facebook_id');
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
        Schema::table('customers',function(Blueprint $table){
            $table->dropColumn(['facebook_sync_at','facebook_id']);
        });
    }
}
