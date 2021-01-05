<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceCompanysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql'))->create('insurance_companys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('insurance_company_name')->unique();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql'))->drop('insurance_companys');
    }
}
