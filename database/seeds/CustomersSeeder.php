<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        App\Models\Customers::create([
            'fullname'     => 'Henrique Silvério',
            'email'        => 'henrique@gmail.com',
            'password'     => '$1$gB6Pqa/F$NPgHjGwOjiuZ1pwgZIjKb/',
            'gender'       => 'M',
            'birthdate'    => '1993-03-20',
            'birthtime'    => '23:00',
            'city'         => 'Jundiaí',
            'phone_number' => '(14)99245-5871',
        ]);

        App\Models\Customers::create([
            'fullname'     => 'Reginaldo Castardo',
            'email'        => 'rcastardo@gmail.com',
            'password'     => '$1$gB6Pqa/F$NPgHjGwOjiuZ1pwgZIjKb/',
            'gender'       => 'M',
            'birthdate'    => '1978-01-18',
            'birthtime'    => '11:00',
            'city'         => 'Jundiaí',
            'phone_number' => '(11)97570-2717',
        ]);

        $faker = Faker::create();
        $i     = 0;

        while ($i < 5) {
            App\Models\Customers::create([
                'fullname'     => $faker->name,
                'email'        => $faker->email,
                'gender'       => 'M',
                'birthdate'    => $faker->date('Y-m-d'),
                'birthtime'    => $faker->time('H:i'),
                'city'         => $faker->city,
                'phone_number' => '(11)97570-2717',
            ]);

            $i++;
        }
    }
}
