<?php

namespace Database\Seeders;

use App\Models\PaymentMethods;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethods::create(['name' => ['ar' => 'الدفع عند الاستلام', 'en' => 'Cash on delivery']]);
        PaymentMethods::create(['name' => ['ar' => 'تحويل سبيشل لاين', 'en' => 'Special Line Transfer']]);
        PaymentMethods::create(['name' => ['ar' => 'التحويل الى التاجر', 'en' => 'Transfer to Vendor']]);
    }
}
