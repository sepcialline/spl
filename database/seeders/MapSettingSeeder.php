<?php

namespace Database\Seeders;

use App\Models\MapSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MapSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MapSetting::create([
            'server_key'=>'AIzaSyBI9Dy68H76Ml1AW1D4oIdsR32z0PGE18Y',
            'client_key'=>'AIzaSyBI9Dy68H76Ml1AW1D4oIdsR32z0PGE18Y',
        ]);
    }
}
