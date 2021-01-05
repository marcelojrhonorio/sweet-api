<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label', 100);
            $table->integer('campaign_field_type_id')->unsigned()->nullable();
            $table->integer('campaign_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('campaign_field_type_id')->references('id')->on('campaign_field_types')->onDelete('cascade');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_fields');
    }
}
