<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsClickoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns_clickout', function (Blueprint $table) {
            $table->increments('id');
            $table->string('answer', 200);
            $table->boolean('affirmative');
            $table->string('link', 255);
            $table->integer('campaigns_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('campaigns_id')->references('id')->on('campaigns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_clickout');
    }
}
