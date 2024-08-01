<?php

namespace Database\Seeders;

use App\Models\Branches;
use App\Models\AccountTree;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /* 1-  Create or Update Branches Revenues  انشاء أو تعديل ايرادات*/


        /* 2- Create or Update Vat account under Libilities  انشاء أو تعديل حساب الضرائب تحت الخصوم  */

        /* 3- Create or Update Branches Vat account انشاء أو تعديل حساب ضرائب الفروع  */

        /* 4- Create or Update Branches Expenses under expenses انشاء أو تعديل حساب مصاريف الأفرع تحت المصاريف */

        /* 5- when create branch set accounts [rev + vat + exp] */

        Branches::create([
            'branch_name' => ['ar' => 'الفرع الرئيسي', 'en' => 'Main Office'],
            'branch_emirat_id' => '1',
            'branch_mobile' => '971529208563',
            'branch_landline' => '97166353753',
            'branch_email' => 'info@specialline.ae',
            'branch_address' => ['en' => 'Haroun Al Rasheed Street - Ajman Corniche Al Rumailah - Al Rumailah 3 - Ajman - United Arab Emirates', 'ar' => 'Haroun Al Rasheed Street - Ajman Corniche Al Rumailah - Al Rumailah 3 - Ajman - United Arab Emirates'],
            // 'branch_postal_code' => '00000',
            'is_main' => 0,
            'is_head_office' => 1,
            'percentage' => 0,
            'status' => 1,
            'revenues_account' => '',
            'vat_account' => '',
            'expenses_account' => ''
        ]);




        Branches::create([
            'branch_name' => ['ar' => 'فرع عجمان', 'en' => 'Ajman Branch'],
            'branch_emirat_id' => '1',
            'branch_mobile' => '971529208563',
            'branch_landline' => '97166353753',
            'branch_email' => 'ajman@specialline.ae',
            'branch_address' => ['en' => 'Haroun Al Rasheed Street - Ajman Corniche Al Rumailah - Al Rumailah 3 - Ajman - United Arab Emirates', 'ar' => 'Haroun Al Rasheed Street - Ajman Corniche Al Rumailah - Al Rumailah 3 - Ajman - United Arab Emirates'],            'branch_postal_code' => '00000',
            'is_main' => 1,
            'is_head_office' => 0,
            // 'percentage' => 1,
            // 'percentage_in' => '100',
            // 'percentage_out' => '100',
            'status' => 1,
            'revenues_account' => '',
            'vat_account' => '',
            'expenses_account' => ''
        ]);

        Branches::create([
            'branch_name' => ['ar' => 'فرع أبوظبي', 'en' => 'Abu Dhabi Branch'],
            'branch_emirat_id' => '4',
            'branch_mobile' => '971529208563',
            'branch_landline' => '97166353753',
            'branch_email' => 'abddhabi@specialline.ae',
            'branch_address' => ['en' => 'Abu Dhabi Branch - United Arab Emirates', 'ar' => 'Abu Dhabi Branch - United Arab Emirates'],
            'branch_postal_code' => '11111',
            'is_main' => 0,
            'is_head_office' => 0,
            // 'percentage' => 1,
            // 'percentage_in' => '100',
            // 'percentage_out' => '50',
            'status' => 1,
            'revenues_account' => '',
            'vat_account' => '',
            'expenses_account' => ''
        ]);

        Branches::create([
            'branch_name' => ['ar' => 'فرع الشارقة', 'en' => 'Sharjah Branch'],
            'branch_emirat_id' => '2',
            'branch_mobile' => '971529208563',
            'branch_landline' => '97166353753',
            'branch_email' => 'sharjah@specialline.ae',
            'branch_address' => ['en' => 'Sharjah Branch - United Arab Emirates', 'ar' => 'Sharjah Branch - United Arab Emirates'],
            'branch_postal_code' => '11111',
            'is_main' => 0,
            'is_head_office' => 0,
            // 'percentage' => 1,
            // 'percentage_in' => '100',
            // 'percentage_out' => '50',
            'status' => 1,
            'revenues_account' => '',
            'vat_account' => '',
            'expenses_account' => ''
        ]);
    }
}
