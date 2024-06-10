<?php

namespace Database\Seeders;

use App\Models\AccountTree;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //1  // 1 assets
        AccountTree::create(['account_level' => 1, 'account_code' => 1, 'account_name' => ['ar' => 'الموجودات', 'en' => 'Assets'], 'account_type' => 0,  'account_parent' => Null, 'account_dc_type' => 1, 'account_final' => 1]);

        //2 //11 fixed assetes
        AccountTree::create(['account_level' => 2, 'account_code' => 11, 'account_name' => ['ar' => 'الموجودات الثابتة', 'en' => 'Fixed Assets'], 'account_type' => 1,  'account_parent' => 1, 'account_dc_type' => 1, 'account_final' => 1]);
        //3 //12 Current assetes
        AccountTree::create(['account_level' => 2, 'account_code' => 12, 'account_name' => ['ar' => 'الموجودات المتداولة', 'en' => 'Current Assets'], 'account_type' => 1,  'account_parent' => 1, 'account_dc_type' => 1, 'account_final' => 1]);
        //4 //13 Ready Money
        AccountTree::create(['account_level' => 2, 'account_code' => 13, 'account_name' => ['ar' => 'الأموال الجاهزة', 'en' => 'Ready Money'], 'account_type' => 1,  'account_parent' => 1, 'account_dc_type' => 1, 'account_final' => 1]);

        ##########################################################################
        //5 // liabilities
        AccountTree::create(['account_level' => 1, 'account_code' => 2, 'account_name' => ['ar' => 'الخصوم', 'en' => 'liabilities'], 'account_type' => 0,  'account_parent' => Null, 'account_dc_type' => 0, 'account_final' => 1]);

        ###########################################################################
        //6 // Net purchases
        AccountTree::create(['account_level' => 1, 'account_code' => 3, 'account_name' => ['ar' => 'صافي المشتريات', 'en' => 'Net purchases'], 'account_type' => 0,  'account_parent' => Null, 'account_dc_type' => 1, 'account_final' => 2]);
        ###########################################################################
        // 7 // Net sales
        AccountTree::create(['account_level' => 1, 'account_code' => 4, 'account_name' => ['ar' => 'صافي المبيعات', 'en' => 'Net sales'], 'account_type' => 0, 'account_parent' => Null, 'account_dc_type' => 0, 'account_final' => 2]);
        ###########################################################################
        // 8 //expenses
        AccountTree::create(['account_level' => 1, 'account_code' => 5, 'account_name' => ['ar' => 'المصاريف', 'en' => 'expenses'], 'account_type' => 0, 'account_parent' => Null, 'account_dc_type' => 1, 'account_final' => 2]);
        ###########################################################################
        // 9 //Revenues
        AccountTree::create(['account_level' => 1, 'account_code' => 6, 'account_name' => ['ar' => 'الايرادات', 'en' => 'Revenues '], 'account_type' => 0, 'account_parent' => Null, 'account_dc_type' => 0, 'account_final' => 2]);
        ##########################################################################
    }
}
