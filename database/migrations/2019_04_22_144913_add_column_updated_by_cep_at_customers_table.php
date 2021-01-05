<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnUpdatedByCepAtCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function($table) {
            $table->timestamp('updated_by_cep_at')
                ->nullable()
                ->after('updated_by_cep');
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
            $table->dropColumn('updated_by_cep_at');
        });
    }
}
