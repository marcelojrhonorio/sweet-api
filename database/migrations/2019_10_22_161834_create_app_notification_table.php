<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('total')->unsigned();
            $table->integer('already_queue')->unsigned();  
            $table->string('status');  
            $table->timestamp('job_canceled_at')->nullable()->default(null);        
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
        Schema::dropIfExists('app_notifications');
    }
}
