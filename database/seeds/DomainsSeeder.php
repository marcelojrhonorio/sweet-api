<?php

use App\Models\Domains;
use Illuminate\Database\Seeder;


class DomainsSeeder extends Seeder
{
    public function run()
    {
        Domains::create([
            'name' => 'teste 1',
            'link'  => 'http://www.teste1.com',
            'status' => 1,
        ]);

        Domains::create([
            'name' => 'CristalClub',
            'link'  => 'http://cristal-club.com',
            'status' => 1,
        ]);

        Domains::create([
            'name' => str_random(10),
            'link'  => 'http://cristal1-club.com',
            'status' => 1,
        ]);

        Domains::create([
            'name' => str_random(10),
            'link'  => 'http://cristal2-club.com',
            'status' => 1,
        ]);

        Domains::create([
            'name' => str_random(10),
            'link'  => 'http://cristal2-club.com',
            'status' => 1,
        ]);
    }
}