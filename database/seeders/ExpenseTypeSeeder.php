<?php

namespace Database\Seeders;

use App\Models\ExpenseType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ExpenseType::create([
            'name' => ['en' => 'Fuel', 'ar' => 'وقود']
        ]);
        ExpenseType::create([
            'name' => ['en' => 'Washing', 'ar' => 'غسيل']
        ]);
        ExpenseType::create([
            'name' => ['en' => 'Change Oil', 'ar' => 'غيار زيت']
        ]);
        ExpenseType::create([
            'name' => ['en' => 'Maintainence', 'ar' => 'صيانة']
        ]);
        ExpenseType::create([
            'name' => ['en' => 'Other', 'ar' => 'اخرى']
        ]);
    }
}
