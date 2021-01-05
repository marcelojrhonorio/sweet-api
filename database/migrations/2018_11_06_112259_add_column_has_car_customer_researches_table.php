<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnHasCarCustomerResearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql'))->table('customer_researches', function (Blueprint $table) {
            $table->boolean('has_car')->nullable()->default(null)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql'))->table('customer_researches', function (Blueprint $table) {
            $table->dropColumn('has_car');
        });
    }
}
