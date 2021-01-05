<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customers_id')->unsigned();
            $table->string('browser_name');
            $table->string('browser_family');
            $table->string('platform_name');
            $table->string('platform_family');
            $table->string('device_family')->nullable();
            $table->string('device_model')->nullable();
            $table->foreign('customers_id')->references('id')->on('customers');

            $table->unique(['customers_id', 'browser_name', 'platform_name']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_devices');
    }
}
