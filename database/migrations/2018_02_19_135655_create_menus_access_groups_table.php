<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusAccessGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus_access_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menus_id')->unsigned();
            $table->integer('access_groups_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('menus_id')->references('id')->on('menus');
            $table->foreign('access_groups_id')->references('id')->on('access_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus_access_groups');
    }
}
