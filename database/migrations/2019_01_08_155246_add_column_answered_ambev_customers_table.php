<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAnsweredAmbevCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ambev_customers', function (Blueprint $table) {
            $table->boolean('answered')->default(false)->after('fired_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ambev_customers', function (Blueprint $table) {
            $table->dropColumn('answered');
        });
    }
}
