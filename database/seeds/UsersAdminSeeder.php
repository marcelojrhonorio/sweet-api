<?php

use Illuminate\Database\Seeder;
use App\Models\Users;

class UsersAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Users::create([
            'fullname'         => 'Henrique',
            'email'            => 'henrique@teste.com',
            'password'         => 'abcd12',
            'active'           => 1,
            'access_groups_id' => 1,
        ]);
    }
}
