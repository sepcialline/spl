<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::create([
            'name' =>['ar'=>'سبيشل لاين لخدمات التوصيل','en'=>'Special Line Delivery Services'],
            'description' =>['ar'=>'سبيشل لاين لخدمات التوصيل','en'=>'Special Line Delivery Services'],
            'logo_en' => 'special_line_en_logo.png',
            'logo_ar' => 'special_line_ar_logo.png',
            'favicon' => 'favicon.png', 
            'url' => 'https://www.specialline.net',   
            'email' => 'info@specialline.net',   
            'mobile' => '+971 55 686 9044', 
            'landline' => '+971 6 524 3753',   
            'emirates_post_license_no' => '000000000',   
            'postal_code' => '000000',   
            'map_longitude' => '55.426624',   
            'map_latitude' => '25.394685',   
            'tax' => '100603385400003', 
            'tax_include' => true, 
            'tax_percentage' => '5', 
            'default_language' => 'en', 
            'timezone' => 'Asia/Dubai', 
            'date_format' => 'y-m-d', 
            'time_format' => '12',   
            'address' =>['ar'=>'الروملية - الروميلة 3 - شارع هارون الرشيد - عجمان - الامارات العربية','en'=>'Al Rumailah - Al Rumailah 3 - Haroon Alrsheed St - Ajman - UAE'], 
            'maintenance_mode' => false,     
               
        ]);
    }
}
