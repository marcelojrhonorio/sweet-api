<?php

use App\Models\AccessGroups;
use Illuminate\Database\Seeder;


class AccessGroupsSeeder extends Seeder
{
    public function run()
    {
        /*AccessGroups::create([
            'name' => 'admin'
        ]);*/

       // DB::table('access_groups')->truncate();

        AccessGroups::create([
            'id'   => 1,
            'name' => 'Administrator',
        ]);

        //AccessGroups::create([
        //    'id'            => 2,
       //     'name'          => 'Manager',
        //]);

        AccessGroups::create([
            'id'   => 3,
            'name' => 'Company',
        ]);

        //AccessGroups::create([
        //    'id'            => 4,
        //    'name'          => 'User',
        //]);
    }
}
