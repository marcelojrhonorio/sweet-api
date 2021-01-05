<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaptorResearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raptor_researches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_id');
            $table->string('hasoffers_id');
            $table->string('affiliate_id');
            $table->string('research_type');
            $table->string('transaction_id');
            $table->string('confirmed');
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
        Schema::dropIfExists('raptor_researches');
    }
}
