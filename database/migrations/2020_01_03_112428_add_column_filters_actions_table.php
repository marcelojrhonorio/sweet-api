<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnFiltersActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actions', function (Blueprint $table) {
            
            $table->addColumn('string', 'filter_ddd', ['length' => 255])->after('enabled')->nullable();
            ///
            $table->addColumn('string', 'filter_operation_begin', ['length' => 2])->after('filter_ddd')->nullable();
            $table->addColumn('integer', 'filter_age_begin')->after('filter_operation_begin')->nullable();
            ///
            $table->addColumn('string', 'filter_operation_end', ['length' => 2])->after('filter_age_begin')->nullable();
            $table->addColumn('integer', 'filter_age_end')->after('filter_operation_end')->nullable();
            ///
            $table->addColumn('string', 'filter_gender', ['length' => 8])->after('filter_age_end')->nullable();
            $table->addColumn('string', 'filter_cep', ['length' => 255])->after('filter_gender')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->dropColumn(['filter_cep', 'filter_gender', 'filter_age_end', 'filter_operation_end', 'filter_age_begin', 'filter_operation_begin', 'filter_ddd']);
        });
    }
}
