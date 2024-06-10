<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShipmentStatuses;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShipmentStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //ShipmentStatuses::truncate();
        ShipmentStatuses::create(['name' => ['ar' => 'قيد الموافقة', 'en' => 'pending approval'],  'html_code' => 'btn-outline-warning',]);
        ShipmentStatuses::create(['name' => ['ar' => 'قيد التسليم', 'en' => 'In progress'], 'html_code' => 'btn-outline-info',]);
        ShipmentStatuses::create(['name' => ['ar' => 'تم التسليم', 'en' => 'Delivered'], 'html_code' => 'btn-outline-success',]);
        ShipmentStatuses::create(['name' => ['ar' => 'مؤجلة', 'en' => 'Delayed'], 'html_code' => 'btn-outline-warning',]);
        ShipmentStatuses::create(['name' => ['ar' => 'محولة', 'en' => 'Transferred'], 'html_code' => 'btn-outline-secondary',]);
        ShipmentStatuses::create(['name' => ['ar' => 'ملغاة', 'en' => 'Canceled'], 'html_code' => 'btn-outline-danger',]);
        ShipmentStatuses::create(['name' => ['ar' => 'تالفة', 'en' => 'Damaged'], 'html_code' => 'btn-outline-dark',]);
        ShipmentStatuses::create(['name' => ['ar' => 'مكررة', 'en' => 'Duplicated'], 'html_code' => 'btn-outline-dark',]);
        ShipmentStatuses::create(['name' => ['ar' => 'مسترجعه', 'en' => 'Returned'], 'html_code' => 'btn-outline-dark',]);
        ShipmentStatuses::create(['name' => ['ar' => 'جديد', 'en' => 'New'],  'html_code' => 'btn-outline-success',]);
    }
}
