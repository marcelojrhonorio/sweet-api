<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table
                ->boolean('weekly_ssi_email')
                ->default(false)
                ->after('count_opened_email');

            $table
                ->dateTime('weekly_ssi_email_at')
                ->nullable()
                ->after('weekly_ssi_email');

            $table
                ->boolean('montly_ssi_email')
                ->default(false)
                ->after('weekly_ssi_email_at');

            $table
                ->dateTime('montly_ssi_email_at')
                ->nullable()
                ->after('montly_ssi_email');
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
            $table->dropColumn([
                'weekly_ssi_email', 
                'weekly_ssi_email_at', 
                'montly_ssi_email',
                'montly_ssi_email_at'
            ]);
        });
    }
}
