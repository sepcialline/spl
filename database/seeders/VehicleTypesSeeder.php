<?php

namespace Database\Seeders;

use App\Models\VehicleTypes;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VehicleTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleTypes::create(['name' => ['ar' => 'سيارة عادية', 'en' => 'Normal Car']]);
        VehicleTypes::create(['name' => ['ar' => 'سيارة مبردة', 'en' => 'Car cooling']]);
        VehicleTypes::create(['name' => ['ar' => 'دراجة نارية', 'en' => 'Bike']]);
    }
}
