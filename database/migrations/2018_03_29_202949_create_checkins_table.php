<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckinsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('checkins', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customers_id');
            $table->unsignedInteger('actions_id');
            $table->unsignedInteger('points');
            $table->timestamps();

            $table->foreign('customers_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');

            $table->foreign('actions_id')
                ->references('id')
                ->on('actions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('checkins');
    }
}
