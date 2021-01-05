<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql'))->create('model_years', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vehicle_model_id')->unsigned();
            $table->string('vehicle_model_fipe_codigo');
            $table->string('vehicle_model_fipe_codigo_2');
            $table->string('vehicle_model_release_name');
            $table->unique(['vehicle_model_id', 'vehicle_model_fipe_codigo', 'vehicle_model_fipe_codigo_2'], 'unique_name_fipe_fipe2');
            $table->integer('year_id')->unsigned();
            $table->foreign('year_id')
                ->references('id')->on('years');
            $table->foreign('vehicle_model_id')
                ->references('id')->on('vehicle_models');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql'))->drop('model_years');
    }
}
