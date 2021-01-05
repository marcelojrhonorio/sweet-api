<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStateCustomerExchangedPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_exchanged_points', function (Blueprint $table) {
            $table->string('state')->nullable()->after('complement');
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
            $table->dropColumn('state');
        });
    }
}
