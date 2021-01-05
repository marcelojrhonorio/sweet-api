<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAppIndicatedByCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function($table) {
            $table->integer('app_indicated_by')->nullable()->unsigned()->after('indicated_by');

            $table->foreign('app_indicated_by')
                  ->references('id')
                  ->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function($table) {
            $table->dropColumn('app_indicated_by');
        });
    }
}
