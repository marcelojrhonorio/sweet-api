<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateAppMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customers_id')->unsigned();
            $table->integer('message_types_id')->unsigned();
            $table->string('link');
            $table->dateTime('opened_at')->nullable();

            $table->softDeletes();

            $table->foreign('customers_id')
                ->references('id')->on('customers');

            $table->foreign('message_types_id')
                ->references('id')->on('app_message_types');

            $table->unique(['customers_id', 'link']);
            
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
        Schema::dropIfExists('app_messages');
    }
}