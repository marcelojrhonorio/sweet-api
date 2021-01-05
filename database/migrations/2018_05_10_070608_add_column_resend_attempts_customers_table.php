<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnResendAttemptsCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->tinyInteger('resend_attempts')
                ->default(0)
                ->after('confirmation_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('customers', 'resend_attempts')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn('resend_attempts');
            });
        }
    }
}
