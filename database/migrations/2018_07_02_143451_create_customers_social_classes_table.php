<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersSocialClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_social_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('interview_id');
            $table->integer('customers_id')->unsigned();
            $table->integer('r15');
            $table->integer('r16');
            $table->integer('r18');
            $table->timestamps();
            $table->foreign('customers_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers_social_classes');
    }
}
