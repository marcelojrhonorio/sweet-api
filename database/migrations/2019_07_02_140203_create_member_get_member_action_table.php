<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberGetMemberActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_get_member_action', function (Blueprint $table) {
           
            $table->increments('id');
            $table->integer('customers_id')->unsigned();
            $table->integer('indicated_by')->unsigned();
            $table->integer('action_id')->default(0);
            $table->enum('action_type', ['Campanha', 'Pesquisa', 'Blog', 'Pesquisa Incentivada', ''])->default('');
            $table->timestamp('won_points')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('customers_id')
                  ->references('id')
                  ->on('customers');

            $table->foreign('indicated_by')
                  ->references('id')
                  ->on('customers');
            
            $table->unique(['customers_id', 'action_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_get_member_action');
    }
}
