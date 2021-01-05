<?php

use App\Models\Users;
use Illuminate\Database\Seeder;


class UsersSeeder extends Seeder
{
    public function run()
    {
        Users::create([
            'fullname'         => 'Victor Castilho',
            'email'            => 'victor.castilho',
            'password'         => 'vic@2018Ca+',
            'active'           => 1,
            'access_groups_id' => 1,
        ]);
    }
}
