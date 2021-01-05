<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSsiFieldsOnCustomer extends Migration
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
            $table->integer('ssi_status')->nullable()->default(0)->after('ip_address');
            $table->text('ssi_return')->nullable()->after('ssi_status');
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
            $table->dropColumn(['ssi_return', 'ssi_status']);
        });
    }
}
