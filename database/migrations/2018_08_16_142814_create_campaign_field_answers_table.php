<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignFieldAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_field_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_answer_id')->unsigned()->nullable();
            $table->string('value', 100);
            $table->integer('campaign_field_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('campaign_answer_id')->references('id')->on('campaign_answers')->onDelete('cascade');
            $table->foreign('campaign_field_id')->references('id')->on('campaign_fields')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_field_answers');
    }
}
