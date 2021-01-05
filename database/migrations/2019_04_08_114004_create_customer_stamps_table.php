<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerStampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_stamps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customers_id')->unsigned();
            $table->integer('stamps_id')->unsigned();
            $table->integer('count_to_stamp');
            $table->timestamps();
            
            $table->foreign('customers_id')
                ->references('id')
                ->on('customers');

            $table->foreign('stamps_id')
                ->references('id')
                ->on('stamps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_stamps');
    }
}
