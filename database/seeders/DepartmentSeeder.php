<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Department = Department::create(['name' =>['en'=> 'Board of Directors','ar'=>'مجلس الادارة']]);
        $Department = Department::create(['name' =>['en'=> 'Programming','ar'=>'البرمجة']]);
        $Department = Department::create(['name' =>['en'=> 'Accounting','ar'=>'محاسبة']]);
        $Department = Department::create(['name' =>['en'=> 'Store Keeper','ar'=>'أمين مستودع']]);
        $Department = Department::create(['name' =>['en'=> 'HR','ar'=>'الموارد البشرية']]);
        $Department = Department::create(['name' =>['en'=> 'Graphic Design','ar'=>'التصميم']]);
        $Department = Department::create(['name' =>['en'=> 'Marketing','ar'=>'تسويق']]);
        $Department = Department::create(['name' =>['en'=> 'Data Entry','ar'=>'ادخال بيانات']]);
        $Department = Department::create(['name' =>['en'=> 'Sales','ar'=>'مبيعات']]);
        $Department = Department::create(['name' =>['en'=> 'public realation','ar'=>'علاقات عامة']]);
        $Department = Department::create(['name' =>['en'=> 'Operation','ar'=>'ادارة عمليات']]);
        $Department = Department::create(['name' =>['en'=> 'Cleaning officer','ar'=>'مسؤول التنظيف']]);

    }
}
