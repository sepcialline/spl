<?php

namespace Database\Seeders;

// use App\Models\War

use App\Models\WarehouseOperations;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WarehouseOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WarehouseOperations::truncate();
        WarehouseOperations::create(['name' => ['en' => 'Import Item', 'ar' => 'استيراد صنف']]);
        WarehouseOperations::create(['name' => ['en' => 'Export Item', 'ar' => 'اخراج صنف']]);
        WarehouseOperations::create(['name' => ['en' => 'Adjust Item', 'ar' => 'تعديل صنف']]);
        WarehouseOperations::create(['name' => ['en' => 'Transfer Item', 'ar' => 'تحويل صنف']]);
        WarehouseOperations::create(['name' => ['en' => 'Add Item', 'ar' => 'اضافة صنف']]);
        WarehouseOperations::create(['name' => ['en' => 'Deliver Item', 'ar' => 'استلام صنف']]);
    }
}
