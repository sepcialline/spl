<?php

namespace Database\Seeders;


use App\Models\TrialBalance;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TrialBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TrialBalance::create([
            'code'=>'00',
            'name'=>['en'=>'trial balance','ar'=>'الميزانية'],
        ]);

        TrialBalance::create([
            'code'=>'01',
            'name'=>['en'=>'profit and loss','ar'=>'الأرباح والخسائر'],
        ]);
        TrialBalance::create([
            'code'=>'02',
            'name'=>['en'=>'Trading','ar'=>'المتاجرة'],
        ]);
    }
}
