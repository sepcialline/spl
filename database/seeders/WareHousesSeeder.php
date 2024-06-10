<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WareHousesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Warehouse::create([
            'warehouse_name'=>['ar'=>'مستودع الفرع الرئيسي','en'=>'Main Office WareHouse'],
            'branch_id'=>'1',
            'status'=>'1'
        ]);
        Warehouse::create([
            'warehouse_name'=>['ar'=>'مستودع فرع عجمان','en'=>'Ajman WareHouse'],
            'branch_id'=>'2',
            'status'=>'1'
        ]);
        Warehouse::create([
            'warehouse_name'=>['ar'=>'مستودع فرع أبو ظبي','en'=>'AbuDhabi WareHouse'],
            'branch_id'=>'3',
            'status'=>'1'
        ]);
    }
}
