<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVVeemLeadsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // change date functions on query compatibility with sqlite to testing and mysql
        $date = env('APP_ENV') === "testing" ? "DATE_FORMAT(date('now', 'start of year', '+2 months'), '%m%Y') as next_month_year, " :
        "DATE_FORMAT(NOW() + INTERVAL 2.5 MONTH, '%m%Y')  as next_month_year,";
        // attach the sweet database;
        $attach_databse = env('APP_ENV') === "testing" ? "ATTACH DATABASE ':memory:' AS sweet;" : null;

        DB::connection(env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql'))
            ->statement($attach_databse .
                "CREATE VIEW v_veem_lead AS
                SELECT
                    concat(r.customer_id,r.id,ca.id) as id,
                    r.customer_id,
                    r.id AS research_id,
                    ca.id as research_answer_id,
                    ca.model_year_id,
                    vm.vehicle_model_name AS vehicle_model,
                    cu.cep AS postal_code,
                    cu.cpf as national_identity,
                    y.year_description AS vehicle_year,
                    YEAR(NOW()) - y.year_description AS vehicle_age,
                    ca.customer_research_answer_has_insurance AS vehicle_has_insurance,
                    ca.customer_research_answer_status_sicronized AS leed_sicronized,
                    ca.customer_research_answer_date_insurace_at AS vehicle_date_insurace,
                    DATE_FORMAT(NOW(), '%m%Y') AS now_month_year,
                    {$date}
                    cu.birthdate AS date_of_birth,
                    cu.gender AS sex,
                    b.brand_name as vehicle_manufacturer,
                    vt.vehicle_type_name as type,
                    cu.fullname AS name,
                    cu.email AS email,
                    cu.phone_number AS cellphone,
                    cu.secondary_phone_number AS telephone,
                    my.vehicle_model_fipe_codigo AS fipe
                FROM
                    sweet_seguro_auto.customer_researches r
                        INNER JOIN
                    sweet_seguro_auto.customer_research_answers ca ON ca.customer_research_id = r.id
                        INNER JOIN
                    sweet.customers cu ON cu.id = r.customer_id
                        INNER JOIN
                    sweet_seguro_auto.model_years my ON ca.model_year_id = my.id
                        INNER JOIN
                    sweet_seguro_auto.years y ON y.id = my.year_id
                        INNER JOIN
                    sweet_seguro_auto.vehicle_models vm ON vm.id = my.vehicle_model_id
                        INNER JOIN
                    sweet_seguro_auto.brands b ON vm.brand_id = b.id
                        INNER JOIN
                    sweet_seguro_auto.vehicle_types vt ON vt.id = vm.vehicle_type_id
                    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        $dettach_databse = env('APP_ENV') === "testing" ? "DETACH DATABASE sweet;" : null;

        DB::connection(env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql'))->statement($dettach_databse . "DROP VIEW v_veem_lead");
    }
}
