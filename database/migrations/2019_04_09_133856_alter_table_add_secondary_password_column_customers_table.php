<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAddSecondaryPasswordColumnCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $password = 'iAdfgKa12p3%&cVk1$@!Gc#!';
            $password = Hash::make($password);

            $table
                ->string('secondary_password')
                ->default($password)
                ->after('password');           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('secondary_password');
        });
    }
}
