<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearchPixelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_pixels', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('research_id');
            $table->unsignedInteger('affiliate_id');
            $table->enum('type', ['1', '2', '3']);
            $table->string('goal_id')->nullable();
            $table->boolean('has_redirect')->default(0);
            $table->string('link_redirect')->nullable();
            $table->timestamps();

            $table->foreign('research_id')
                ->references('id')
                ->on('researches')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('research_pixels');
    }
}
