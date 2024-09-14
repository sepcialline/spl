<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create(['name' => ['ar' => 'طلب مندوب استلام', 'en' => 'Request a receiving representative'], 'status' => 1]);
        Service::create(['name' => ['ar' => 'طلب متجر', 'en' => 'Shop Request'], 'status' => 1]);
        Service::create(['name' => ['ar' => 'طلب خدمة التصوير', 'en' => 'Request a photography service'], 'status' => 1]);
        Service::create(['name' => ['ar' => 'طلب خدمة التصميم', 'en' => 'Request design service'], 'status' => 1]);
        Service::create(['name' => ['ar' => 'طلب خدمة تخزين مبرد', 'en' => 'Request a cold storage service'], 'status' => 1]);
        Service::create(['name' => ['ar' => 'طلب خدمة توصيل مبرد', 'en' => 'Request a refrigerator delivery service'], 'status' => 1]);
    }
}
