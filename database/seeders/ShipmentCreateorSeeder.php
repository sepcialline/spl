<?php

namespace Database\Seeders;

use App\Models\ShipmentCreator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipmentCreateorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShipmentCreator::create(['id'=>'1','name'=>'admin',]);
        ShipmentCreator::create(['id'=>'2','name'=>'branch_employee',]);
        ShipmentCreator::create(['id'=>'3','name'=>'company_vendor',]);
        ShipmentCreator::create(['id'=>'4','name'=>'rep',]);
        ShipmentCreator::create(['id'=>'5','name'=>'user',]);
    }
}
