<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppIndicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_indications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hash');
            $table->integer('customers_id')->unsigned()->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('customers_id')
                ->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_indications');
    }
}
