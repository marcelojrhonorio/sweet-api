<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStatusCustomerExchangedPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_exchanged_points', function (Blueprint $table) {
            $table->integer('status_id')->unsigned()->nullable()->after('points');
            
            $table->foreign('status_id')
                ->references('id')
                ->on('exchanged_points_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_exchanged_points', function (Blueprint $table) {
            $table->dropForeign('customer_exchanged_points_status_id_foreign');
            $table->dropColumn('status_id');
        });
    }
}
