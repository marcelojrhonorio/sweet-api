<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsHasDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns_has_domains', function (Blueprint $table) {
            $table->integer('campaigns_id')->unsigned()->nullable();
            $table->foreign('campaigns_id')->references('id')->on('campaigns')->onDelete('cascade');

            $table->integer('domains_id')->unsigned()->nullable();
            $table->foreign('domains_id')->references('id')->on('domains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns_has_domains');
    }
}
