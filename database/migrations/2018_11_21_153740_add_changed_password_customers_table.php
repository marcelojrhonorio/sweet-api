<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChangedPasswordCustomersTable extends Migration
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
            $table->boolean('changed_password')->nullable()->after('store_logins');
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
            $table->dropColumn('changed_password');
        });          
    }
}
