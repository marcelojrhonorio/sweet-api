<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionTypeMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_type_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('action_id');
            $table->unsignedInteger('action_type_id');
            $table->string('key');
            $table->string('value');
            $table->timestamps();

            $table->foreign('action_id')
                ->references('id')
                ->on('actions')
                ->onDelete('cascade');

            $table->foreign('action_type_id')
                ->references('id')
                ->on('action_types')
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
        Schema::dropIfExists('action_type_metas');
    }
}
