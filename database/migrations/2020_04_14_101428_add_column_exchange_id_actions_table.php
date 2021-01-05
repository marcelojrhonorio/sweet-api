<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnExchangeIdActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actions', function($table) {
           
            $table->integer('exchange_id')
                  ->after('action_type_id')
                  ->unsigned()
                  ->nullable();

            $table->foreign('exchange_id')
                  ->references('id')
                  ->on('customer_exchanged_points_sm');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actions', function($table) {
            $table->dropForeign('actions_exchange_id_foreign');
            $table->dropColumn('exchange_id');           
            
         });
    }
}
