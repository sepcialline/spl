<?php

namespace Database\Seeders;

use App\Models\Branches;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branches::create([
            'branch_name'=>['ar'=>'الفرع الرئيسي','en'=>'Main Office'],
            'branch_emirat_id'=>'1',
            'branch_mobile'=>'971529208563',
            'branch_landline'=>'97166353753',
            'branch_email'=>'info@specialline.ae',
            'branch_address'=>'Haroun Al Rasheed Street - Ajman Corniche Al Rumailah - Al Rumailah 3 - Ajman - United Arab Emirates',
            'branch_postal_code'=>'00000',
            'is_main'=>1,
            'percentage'=>0,
            'status'=>1,
        ]);
        Branches::create([
            'branch_name'=>['ar'=>'فرع عجمان','en'=>'Ajman Branch'],
            'branch_emirat_id'=>'1',
            'branch_mobile'=>'971529208563',
            'branch_landline'=>'97166353753',
            'branch_email'=>'ajman@specialline.ae',
            'branch_address'=>'Haroun Al Rasheed Street - Ajman Corniche Al Rumailah - Al Rumailah 3 - Ajman - United Arab Emirates',
            'branch_postal_code'=>'00000',
            'is_main'=>0,
            'percentage'=>1,
            'percentage_in'=>'100',
            'percentage_out'=>'100',
            'status'=>1,
        ]);

        Branches::create([
            'branch_name'=>['ar'=>'فرع أبوظبي','en'=>'Abu Dhabi Branch'],
            'branch_emirat_id'=>'4',
            'branch_mobile'=>'971529208563',
            'branch_landline'=>'97166353753',
            'branch_email'=>'abddhabi@specialline.ae',
            'branch_address'=>'Abu Dhabi Branch - United Arab Emirates',
            'branch_postal_code'=>'11111',
            'is_main'=>0,
            'percentage'=>1,
            'percentage_in'=>'100',
            'percentage_out'=>'50',
            'status'=>1,
        ]);

        Branches::create([
            'branch_name'=>['ar'=>'فرع الشارقة','en'=>'Sharjah Branch'],
            'branch_emirat_id'=>'2',
            'branch_mobile'=>'971529208563',
            'branch_landline'=>'97166353753',
            'branch_email'=>'sharjah@specialline.ae',
            'branch_address'=>'Sharjah Branch - United Arab Emirates',
            'branch_postal_code'=>'11111',
            'is_main'=>0,
            'percentage'=>1,
            'percentage_in'=>'100',
            'percentage_out'=>'50',
            'status'=>1,
        ]);
    }
}
