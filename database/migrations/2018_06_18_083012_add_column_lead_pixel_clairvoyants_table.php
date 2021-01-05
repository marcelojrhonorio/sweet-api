<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnLeadPixelClairvoyantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clairvoyants', function (Blueprint $table) {
            $table->string('lead')->after('phone_home')->default('');
            $table->string('pixel')->after('lead')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clairvoyants', function (Blueprint $table) {
            $table->dropColumn(['lead', 'pixel']);
        });
    }
}
