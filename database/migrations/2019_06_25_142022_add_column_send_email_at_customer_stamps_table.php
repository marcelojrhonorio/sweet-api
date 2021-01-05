<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSendEmailAtCustomerStampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_stamps', function($table) {
            $table->timestamp('send_email_at')
                  ->nullable()
                  ->default(null)
                  ->after('count_to_stamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_stamps', function($table) {
            $table->dropColumn('send_email_at');
        });
    }
}
