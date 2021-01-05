<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('title', 150);
            $table->string('question', 255);
            $table->string('path_image', 255)->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('mobile');
            $table->boolean('desktop');
            $table->string('postback_url', 255)->nullable();
            $table->string('config_page', 255)->nullable();
            $table->string('config_email', 60)->nullable();
            $table->integer('visualized', false);
            $table->integer('campaign_types_id')->unsigned()->nullable();
            $table->integer('companies_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('campaign_types_id')->references('id')->on('campaign_types');
            $table->foreign('companies_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign');
    }
}
