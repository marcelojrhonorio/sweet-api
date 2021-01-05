<?php

use App\Models\ActionTypeMeta;
use Illuminate\Database\Seeder;

class ActionTypeMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ActionTypeMeta::create([
            'action_id'      => 1,
            'action_type_id' => 1,
            'key'            => 'url',
            'value'          => 'https://google.com',
        ]);

        ActionTypeMeta::create([
            'action_id'      => 2,
            'action_type_id' => 1,
            'key'            => 'url',
            'value'          => 'https://facebook.com',
        ]);

        ActionTypeMeta::create([
            'action_id'      => 3,
            'action_type_id' => 1,
            'key'            => 'url',
            'value'          => 'https://twitter.com',
        ]);

        ActionTypeMeta::create([
            'action_id'      => 4,
            'action_type_id' => 1,
            'key'            => 'url',
            'value'          => 'https://youtube.com',
        ]);

        ActionTypeMeta::create([
            'action_id'      => 5,
            'action_type_id' => 1,
            'key'            => 'url',
            'value'          => 'https://instagram.com',
        ]);
    }
}
