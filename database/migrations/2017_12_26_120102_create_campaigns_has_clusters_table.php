<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsHasClustersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns_has_clusters', function (Blueprint $table) {
            $table->integer('campaigns_id')->unsigned()->nullable();
            $table->foreign('campaigns_id')->references('id')->on('campaigns')->onDelete('cascade');

            $table->integer('clusters_id')->unsigned()->nullable();
            $table->foreign('clusters_id')->references('id')->on('clusters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns_has_clusters');
    }
}
