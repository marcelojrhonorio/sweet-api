<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialClassFinalSocialClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_SOCIAL_CLASS', 'social_class_mysql'))->create('final_social_class', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customers_id')->unsigned();
            $table->integer('final_points')->unsigned();
            $table->string('final_class_by_income');
            $table->string('final_class_by_questions');

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
        Schema::connection(env('DB_CONNECTION_SOCIAL_CLASS', 'social_class_mysql'))->drop('final_social_class');
    }
}
