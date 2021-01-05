<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewEmailFieldsCustomers extends Migration
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
            $table->string('allin_return_first_email', 255)->nullable()->after('email');
            $table->dateTime('last_opened_email')->nullable()->after('allin_return_first_email');
            $table->integer('count_opened_email')->default(0)->nullable()->after('last_opened_email');
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
            $table->dropColumn(['count_opened_email','last_opened_email','allin_return_first_email']);
        });
    }
}
