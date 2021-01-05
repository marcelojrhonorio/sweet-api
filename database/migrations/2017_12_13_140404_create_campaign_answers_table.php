<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('answer', 50);
            $table->integer('campaigns_id')->unsigned()->nullable();
            $table->integer('customers_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('campaigns_id')->references('id')->on('campaigns');
            $table->foreign('customers_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_answers');
    }
}
