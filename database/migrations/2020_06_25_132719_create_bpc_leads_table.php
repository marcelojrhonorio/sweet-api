<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBpcLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bpc_leads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip_address');
            $table->string('browser_name');
            $table->string('browser_family');
            $table->string('platform_name');
            $table->string('platform_family');
            $table->string('device_family');
            $table->string('device_model');
            $table->timestamps();

            $table->unique(['ip_address', 'browser_name', 'platform_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bpc_leads');
    }
}
