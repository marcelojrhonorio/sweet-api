<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use App\Models\Companies;

class CompaniesSeeder extends Seeder
{

    public function run()
    {

        $faker = Faker::create();

        $i = 0;
        $cnpj = 1000;
        while ($i < 3) {


            Companies::create([
                'name' => $faker->name,
                'cnpj' => $cnpj,
                'nickname' => $faker->company
            ]);
            $cnpj++;
            $i++;

        }
    }

}