<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOrderFiltersCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->addColumn('integer', 'order')->after('id_has_offers')->nullable();
            $table->addColumn('string', 'filter_ddd', ['length' => 255])->after('order')->nullable();
            ///
            $table->addColumn('string', 'filter_operation_begin', ['length' => 2])->after('order')->nullable();
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
        Schema::table('campaigns', function (Blueprint $table) {
            //$table->dropColumn(['filter_cep', 'filter_gender', 'filter_age_end', 'filter_operation_end', 'filter_age_begin', 'filter_operation_begin', 'filter_ddd', 'order']);
        });
    }
}
