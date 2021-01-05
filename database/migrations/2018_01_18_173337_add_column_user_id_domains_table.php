<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUserIdDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->addColumn('integer', 'user_id_created')->default(1)->after('status');
            $table->addColumn('integer', 'user_id_updated')->default(1)->after('user_id_created');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->dropColumn(['user_id_updated', 'user_id_created']);

        });
    }
}
