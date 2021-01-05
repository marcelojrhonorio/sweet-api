<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCompletedCustomerResearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql'))->table('customer_researches', function (Blueprint $table) {
            $table
                ->unsignedTinyInteger('completed')
                ->default(0)
                ->after('id');
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
            $table->dropColumn('completed');
        });
    }
}
