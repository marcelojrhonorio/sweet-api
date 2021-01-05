<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStoreLoginsCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('store_logins')->nullable()->after('indicated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('store_logins');
        });        
    }
}
