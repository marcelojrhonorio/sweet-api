<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql'))->create('vehicle_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vehicle_model_name');
            $table->integer('vehicle_type_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('brand_id')
                ->references('id')->on('brands');
            $table->foreign('vehicle_type_id')
                ->references('id')->on('vehicle_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql'))->drop('vehicle_models');
    }
}
