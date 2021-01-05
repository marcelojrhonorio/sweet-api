<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnUpdatedByCepCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function($table) {
            $table->boolean('updated_by_cep')
                ->default(false)
                ->after('patch_cep_at');

            $table->boolean('invalid_cep')
                ->default(false)
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
            $table->dropColumn(['updated_by_cep', 'invalid_cep']);
        });
    }
}
