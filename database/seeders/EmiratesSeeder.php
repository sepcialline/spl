<?php

namespace Database\Seeders;

use App\Models\Emirates;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmiratesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Emirates::create(['name' =>['ar'=>'عجمان','en'=>'Ajman'], 'code'=>'AJ']);
        Emirates::create(['name' =>['ar'=>'الشارقة','en'=>'Sharjah'], 'code'=>'SH']);
        Emirates::create(['name' =>['ar'=>'دبي','en'=>'Dubai'], 'code'=>'DU']);
        Emirates::create(['name' =>['ar'=>'ابوظبي','en'=>'Abu Dhabi'], 'code'=>'AD']);
        Emirates::create(['name' =>['ar'=>'العين','en'=>'Al Ain'], 'code'=>'AA']);
        Emirates::create(['name' =>['ar'=>'الفجيرة','en'=>'Fujairah'], 'code'=>'FU']);
        Emirates::create(['name' =>['ar'=>'راس الخيمة','en'=>'Ras Al-Khaimah'], 'code'=>'RA']);
        Emirates::create(['name' =>['ar'=>'ام القيوين','en'=>'Umm Al Quwain'], 'code'=>'UQ']);
    }
}
