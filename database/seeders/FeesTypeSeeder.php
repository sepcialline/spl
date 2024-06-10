<?php

namespace Database\Seeders;

use App\Models\FeesType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeesTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FeesType::create([
            'name'=>['ar'=>'عند العميل','en'=>'On Clinet']
        ]);
        FeesType::create([
            'name'=>['ar'=>'عند التاجر','en'=>'On Vendor']
        ]);
        FeesType::create([
            'name'=>['ar'=>'شحن مجاني','en'=>'Free']
        ]);
    }
}
