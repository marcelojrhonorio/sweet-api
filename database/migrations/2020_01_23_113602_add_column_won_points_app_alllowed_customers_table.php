<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnWonPointsAppAlllowedCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_allowed_customers', function($table) {
            $table->timestamp('won_points')->nullable()->after('customers_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_allowed_customers', function($table) {
            $table->dropColumn('won_points');
        });
    }
}
