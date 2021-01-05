<?php

use Illuminate\Database\Migrations\Migration;

class CreateSsiLeadsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $date = env('APP_ENV') !== "testing" ? "DAY(c.birthdate) AS daydob, MONTH(c.birthdate) AS monthdob,YEAR(c.birthdate) AS yeardob," :
        "strftime('%Y',c.birthdate) as yeardob,strftime('%m',c.birthdate) as monthdob, strftime('%d',c.birthdate) as daydob, ";
        DB::statement("CREATE VIEW
                            v_ssi_lead AS
                        SELECT
                            c.id,
                            c.id AS customer_id,
                            {$date}
                            c.gender,
                            REPLACE(c.cep, '.', '') AS postalcode,
                            c.deleted_at
                        FROM
                            customers as c");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement("DROP VIEW v_ssi_lead");
    }
}
