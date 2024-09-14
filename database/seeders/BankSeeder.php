<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            [
                'name_bank' => ['ar' => 'بنك أبو ظبي التجاري', 'en' => 'Abu Dhabi Commercial Bank'],
                'logo' => 'adcb.png',
                'shorted_bank_name' => 'ADCB Bank',
            ],
            [
                'name_bank' => ['ar' => 'بنك أبو ظبي الاسلامي', 'en' => 'Abu Dhabi Islamic Bank'],
                'logo' => 'ADIB.png',
                'shorted_bank_name' => 'ADIB Bank',
            ],
            [
                'name_bank' => ['ar' => 'بنك الشارقة', 'en' => 'Sharjah Bank'],
                'logo' => 'BankOfSharjah.png',
                'shorted_bank_name' => 'Sharjah Bank',
            ],
            [
                'name_bank' => ['ar' => 'بنك دبي التجاري', 'en' => 'Commercial Bank Dubai'],
                'logo' => 'CommercialBankDubai.png',
                'shorted_bank_name' => 'Commercial Dubai',
            ],
            [
                'name_bank' => ['ar' => 'بنك دبي الاسلامي', 'en' => 'Dubai Islamic Bank'],
                'logo' => 'DubaiIslamicBank.png',
                'shorted_bank_name' => 'Dubai Islamic Bank',
            ],
            [
                'name_bank' => ['ar' => 'بنك الامارات الاسلامي', 'en' => 'Emirates Islamic'],
                'logo' => 'EmiratesIslamic.png',
                'shorted_bank_name' => 'Emirates Islamic',
            ],
            [
                'name_bank' => ['ar' => 'بنك أبو ظبي الأول', 'en' => 'First Abu Dhabi Bank'],
                'logo' => 'fab1.png',
                'shorted_bank_name' => 'FAB1',
            ],
            [
                'name_bank' => ['ar' => 'بنك المشرق', 'en' => 'Mashreq'],
                'logo' => 'mashreq.png',
                'shorted_bank_name' => 'Mashreq',
            ],
            [
                'name_bank' => ['ar' => 'بنك الماريا المحلي', 'en' => 'Al Maryah Community Bank'],
                'logo' => 'mbank.png',
                'shorted_bank_name' => 'MBank',
            ],
            [
                'name_bank' => ['ar' => 'بنك الامارات دبي الوطني', 'en' => 'Emirates NBD'],
                'logo' => 'NBD.png',
                'shorted_bank_name' => 'NBD',
            ],
            [
                'name_bank' => ['ar' => 'بنك راس الخيمة الوطني', 'en' => 'RAKBANK'],
                'logo' => 'RAKBAnk.png',
                'shorted_bank_name' => 'RAKBAnk',
            ],
        ];

        foreach ($banks as $bank) {
            Bank::create($bank);
        }
    }
}
