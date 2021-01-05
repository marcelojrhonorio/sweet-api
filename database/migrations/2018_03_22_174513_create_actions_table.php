<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('action_category_id')->unsigned();
            $table->string('title');
            $table->string('description');
            $table->string('path_image');
            $table->integer('grant_points');
            $table->timestamps();

            $table->foreign('action_category_id')
                ->references('id')
                ->on('action_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('actions');
    }
}
