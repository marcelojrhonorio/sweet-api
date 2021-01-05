<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersForwardingStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_forwarding_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customers_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->boolean('status')->nullable();
            
            $table->foreign('customers_id')->references('id')->on('customers');
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
        Schema::dropIfExists('customers_forwarding_status');
    }
}
