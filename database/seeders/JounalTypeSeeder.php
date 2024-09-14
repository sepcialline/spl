<?php

namespace Database\Seeders;

use App\Models\JounalType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JounalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JounalType::create([
            'name'=>['ar'=>'قيد يومي','en'=>'journey Voucher']
        ]);
        JounalType::create([
            'name'=>['ar'=>'سند قبض','en'=>'recipt Voucher']
        ]);
        JounalType::create([
            'name'=>['ar'=>'سند صرف','en'=>'payment Voucher']
        ]);
        JounalType::create([
            'name'=>['ar'=>'قيد مبيعات','en'=>'Sales Voucher']
        ]);
    }
}
