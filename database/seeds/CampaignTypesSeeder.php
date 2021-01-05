<?php

use Illuminate\Database\Seeder;

class CampaignTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['type' => 'Sponsor', 'status' => 0],
            ['type' => 'COREG simples', 'status' => 1],
            ['type' => 'Super COREG', 'status' => 0],
            ['type' => 'ClickOut', 'status' => 1],
            ['type' => 'ClickOut Siteunder', 'status' => 0],
            ['type' => 'ClickOut Agressivo', 'status' => 0],
        ];

        foreach ($types as $type) {
            App\Models\CampaignTypes::create([
                'type' => $type['type'],
                'status' => $type['status'],
            ]);
        }
    }
}
