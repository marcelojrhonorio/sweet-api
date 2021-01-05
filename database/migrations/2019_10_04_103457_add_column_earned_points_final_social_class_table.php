<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnEarnedPointsFinalSocialClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_SOCIAL_CLASS', 'social_class_mysql'))->table('final_social_class', function (Blueprint $table) {
            $table->integer('earned_points')->after('final_class_by_questions')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_CONNECTION_SOCIAL_CLASS', 'social_class_mysql'))->table('final_social_class', function (Blueprint $table) {
            $table->dropColumn('earned_points');
        });
    }
}
