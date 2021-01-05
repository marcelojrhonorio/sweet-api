<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckinResearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkin_researches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customers_id');
            $table->unsignedInteger('researches_id');
            $table->timestamps();

            $table->foreign('customers_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');

            $table->foreign('researches_id')
                ->references('id')
                ->on('researches')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkin_researches');
    }
}
