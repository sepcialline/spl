<?php

namespace Database\Seeders;

use App\Models\COA;
use App\Models\COALevelI;
use App\Models\COALevelII;
use App\Models\COALevelIII;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChartOfAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//////////////////////////////////////////////////الموجودات//////////////////////////////////////////////////////////////////////////
        // الموجودات  1
        $coa_assets = COA::create(['name' => ['ar' => 'الموجودات', 'en' => 'Assets'], 'code' => '1', 'trial_balance_id' => '1']);
/********************************************الموجودات الثابتة***************************************************************************** */
        ////// 11 الموجودات الثابتة
            $coa_fixed_assets = COALevelI::create([
                'name' => ['en'=> 'Fixed assets', 'ar' => 'موجودات ثابتة'], 'code' => '11', 'coa_id' => $coa_assets->id
            ]);

        //////// 111 الأراضي
                COALevelII::create([
                    'name' => ['en'=> 'Lands', 'ar' => 'الأراضي'], 'code' => '111', 'coa_i_id' => $coa_fixed_assets->id
                ]);
        //////// 112 عقارات
                COALevelII::create([
                    'name' => ['en'=> 'real estate', 'ar' => 'عقارات'], 'code' => '112', 'coa_i_id' => $coa_fixed_assets->id
                ]);
########################################اثاث ومفروشات ########################################################################
        //////// 113 اثاث ومفروشات
                $coa_furniture = COALevelII::create([
                    'name' => ['en'=> 'furniture', 'ar' => 'اثاث ومفروشات'], 'code' => '113', 'coa_i_id' => $coa_fixed_assets->id
                ]);
        ///////////// 113001 كولر رويال
                COALevelIII::create([
                    'name' => ['en'=> 'Royal Cooler', 'ar' => 'كولر رويال'], 'code' => '113001', 'coa_i_i_id' => $coa_furniture->id
                ]);
###############################################################################################################################

        //////// 114 سيارات
                COALevelII::create([
                    'name' => ['en'=> 'Cars', 'ar' => 'سيارات'], 'code' => '114', 'coa_i_id' => $coa_fixed_assets->id
                ]);
        //////// 115 الدراجات النارية
                COALevelII::create([
                    'name' => ['en'=> 'Motor cycles', 'ar' => 'الدراجات النارية'], 'code' => '115', 'coa_i_id' => $coa_fixed_assets->id
                ]);


#####################################################أجهزة كمبيوتر وسوفت وير##################################################

        //////// 116 أجهزة كمبيوتر وسوفت وير
                $coa_software_and_computers = COALevelII::create([
                    'name' => ['en'=> 'Software and computers', 'ar' => 'أجهزة كمبيوتر وسوفت وير'], 'code' => '116', 'coa_i_id' => $coa_fixed_assets->id
                ]);
        ///////////// 116001 طابعة كانون
        COALevelIII::create([
            'name' => ['en'=> 'Canon Printer', 'ar' => 'طابعة كانون'], 'code' => '116001', 'coa_i_i_id' => $coa_software_and_computers->id
        ]);
        ///////////// 116002 سيرفر
        COALevelIII::create([
            'name' => ['en'=> 'Server', 'ar' => 'سيرفر'], 'code' => '116002', 'coa_i_i_id' => $coa_software_and_computers->id
        ]);
        ///////////// 116003 طابعة ايبسون
        COALevelIII::create([
            'name' => ['en'=> 'Epson Printer', 'ar' => 'طابعة ايبسون'], 'code' => '116003', 'coa_i_i_id' => $coa_software_and_computers->id
        ]);
        ///////////// 116004 كاميرات
        COALevelIII::create([
            'name' => ['en'=> 'Cameras', 'ar' => 'كاميرات'], 'code' => '116004', 'coa_i_i_id' => $coa_software_and_computers->id
        ]);
###############################################################################################################################
        //////// 117 عدد وأدوات
                COALevelII::create([
                    'name' => ['en'=> 'tools', 'ar' => 'عدد وأدوات'], 'code' => '117', 'coa_i_id' => $coa_fixed_assets->id
                ]);
        //////// 118 مصاريف تأسيس
                COALevelII::create([
                    'name' => ['en'=> 'Establishment expenses', 'ar' => 'مصاريف تأسيس'], 'code' => '118', 'coa_i_id' => $coa_fixed_assets->id
                ]);
        //////// 119 أصول غير ملموسة
                COALevelII::create([
                    'name' => ['en'=> 'Intangible assets', 'ar' => 'أصول غير ملموسة'], 'code' => '119', 'coa_i_id' => $coa_fixed_assets->id
                ]);
/***********************************************الموجودات المتداولة***************************************************************************** */
            // 12 الموجودات المتداولة
            $coa_current_assets = COALevelI::create([
                'name' => ['en'=> 'Current assets', 'ar' => 'موجودات متداولة'], 'code' => '12', 'coa_id' => $coa_assets->id
            ]);
        //////// 121 الزبائن
        COALevelII::create([
            'name' => ['en'=> 'customers', 'ar' => 'الزبائن'], 'code' => '121', 'coa_i_id' => $coa_current_assets->id
        ]);
################################################مدينون مختلفون######################################################################
        //////// 122 مدينون مختلفون
        $coa_various_debtors = COALevelII::create([
            'name' => ['en'=> 'Various debtors', 'ar' => 'مدينون مختلفون'], 'code' => '122', 'coa_i_id' => $coa_current_assets->id
        ]);
        ///////////// 122001 ايجار مقدم
        COALevelIII::create([
            'name' => ['en'=> 'advance rant', 'ar' => 'ايجار مقدم'], 'code' => '122001', 'coa_i_i_id' => $coa_various_debtors->id
        ]);
        ///////////// 122002 تأمين مقدم.
        COALevelIII::create([
            'name' => ['en'=> 'Advance insurance', 'ar' => 'تأمين مقدم'], 'code' => '122002', 'coa_i_i_id' => $coa_various_debtors->id
        ]);

        ///////////// 122003  فخري حساب التطبيقات
        COALevelIII::create([
            'name' => ['en'=> 'Fakhri / Applications Account', 'ar' => 'فخري/ حساب التطبيقات'], 'code' => '122003', 'coa_i_i_id' => $coa_various_debtors->id
        ]);

        ///////////// 122004  رواتب مدفوعة مسبقاً
        COALevelIII::create([
            'name' => ['en'=> 'Advance paid salaries', 'ar' => 'رواتب مدفوعة مسبقاً'], 'code' => '122004', 'coa_i_i_id' => $coa_various_debtors->id
        ]);
        ///////////// 122005  أوردرهير
        COALevelIII::create([
            'name' => ['en'=> 'Order Here', 'ar' => 'أوردرهير'], 'code' => '122005', 'coa_i_i_id' => $coa_various_debtors->id
        ]);
        ///////////// 122006  معلق حساب البنك
        COALevelIII::create([
            'name' => ['en'=> 'Bank account suspended', 'ar' => 'معلق حساب البنك'], 'code' => '122006', 'coa_i_i_id' => $coa_various_debtors->id
        ]);
        ///////////// 122007  مجموعة بريد الامارات
        COALevelIII::create([
            'name' => ['en'=> 'Emirates Post Group', 'ar' => 'مجموعة بريد الامارات'], 'code' => '122007', 'coa_i_i_id' => $coa_various_debtors->id
        ]);
        ///////////// 122008  دعاية واعلان وتسويق مقدم
        COALevelIII::create([
            'name' => ['en'=> 'advertising and marketing provided', 'ar' => 'دعاية واعلان وتسويق مقدم'], 'code' => '122008', 'coa_i_i_id' => $coa_various_debtors->id
        ]);
        ///////////// 122009  م.سوفت وير وبرمجة مقدم
        COALevelIII::create([
            'name' => ['en'=> 'Software and programming provider', 'ar' => 'م.سوفت وير وبرمجة مقدم'], 'code' => '122009', 'coa_i_i_id' => $coa_various_debtors->id
        ]);
##############################################################مسحوبات الشركاء####################################################################
        //////// 123 مسحوبات الشركاء
        $coa_partner_withdrawals =COALevelII::create([
            'name' => ['en'=> 'Partner withdrawals', 'ar' => 'مسحوبات الشركاء'], 'code' => '123', 'coa_i_id' => $coa_current_assets->id
        ]);
        ///////////// 12301 1 مسحوبات الشريك
        COALevelIII::create([
            'name' => ['en'=> 'Partner withdrawals 1', 'ar' => 'مسحوبات الشريك 1'], 'code' => '12301', 'coa_i_i_id' => $coa_partner_withdrawals->id
        ]);
#####################################################المخزون#############################################################################

        //////// 124 المخزون
        $coa_inventory = COALevelII::create([
            'name' => ['en'=> 'Inventory', 'ar' => 'المخزون'], 'code' => '124', 'coa_i_id' => $coa_current_assets->id
        ]);
        ///////////// 1241  مخزون بضاعة جاهزة اخر المدة
        COALevelIII::create([
            'name' => ['ar'=> 'مخزون بضاعة جاهزة اخر المدة', 'en' => 'Stock of finished goods at the end of the period'], 'code' => '1241', 'coa_i_i_id' => $coa_inventory->id
        ]);
########################################################ذمم الموظفين##################################################################################
        //////// 125 ذمم الموظفين
        $coa_employee_receivables = COALevelII::create([
            'name' => ['en'=> 'Employee receivables', 'ar' => 'ذمم الموظفين'], 'code' => '125', 'coa_i_id' => $coa_current_assets->id
        ]);

        ///////////// 125001  السيد أبو أنس
        COALevelIII::create([
            'name' => ['ar'=> 'السيد أبو أنس', 'en' => 'Ms. Abu Anas'], 'code' => '125001', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125002  محمد شايف
        COALevelIII::create([
            'name' => ['en'=> 'محمد شايف', 'ar' => 'Mohammad shayef'], 'code' => '125002', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125003  آمنة
        COALevelIII::create([
            'name' => ['ar'=> 'آمنة', 'en' => 'Amna'], 'code' => '125003', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125004  جواد سلوم
        COALevelIII::create([
            'name' => ['ar'=> 'جواد سلوم', 'en' => 'Jawad Saloum'], 'code' => '125004', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125005  عبدالمجيد الحكمي
        COALevelIII::create([
            'name' => ['ar'=> 'عبدالمجيد الحكمي', 'en' => 'AbdAlMajeed AlHakmi'], 'code' => '125005', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125006  جميل
        COALevelIII::create([
            'name' => ['ar'=> 'جميل', 'en' => 'Gameel'], 'code' => '125006', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125007  عرفان
        COALevelIII::create([
            'name' => ['ar'=> 'عرفان', 'en' => 'Erfan'], 'code' => '125007', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125008  احسان
        COALevelIII::create([
            'name' => ['ar'=> 'احسان', 'en' => 'Ihsan'], 'code' => '125008', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125009  محمد السر
        COALevelIII::create([
            'name' => ['ar'=> 'محمد السر', 'en' => 'Mohammad AlSer'], 'code' => '125009', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125010  صالح الشامي
        COALevelIII::create([
            'name' => ['ar'=> 'صالح الشامي', 'en' => 'Saleh Al shami'], 'code' => '125010', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125011  ابراهيم قاسم
        COALevelIII::create([
            'name' => ['ar'=> 'ابراهيم قاسم', 'en' => 'Ibrahim Kasem'], 'code' => '125011', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125012  رامي محمود
        COALevelIII::create([
            'name' => ['ar'=> 'رامي محمود', 'en' => 'Rami Mahmoud'], 'code' => '125012', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125013  عبدالرحمن سالم
        COALevelIII::create([
            'name' => ['en'=> 'Abdulrhman Salem', 'ar' => 'عبدالرحمن سالم'], 'code' => '125013', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125014  وليد خلف
        COALevelIII::create([
            'name' => ['en'=> 'Waleed Khalaf', 'ar' => 'وليد خلف'], 'code' => '125014', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125015  تحسين خلف
        COALevelIII::create([
            'name' => ['en'=> 'Tahseen Khalaf', 'ar' => 'تحسين خلف'], 'code' => '125015', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125016  أمير محمود
        COALevelIII::create([
            'name' => ['en'=> 'Ameer Mahmoud', 'ar' => 'أمير محمود'], 'code' => '125016', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125017  ابراهيم الشيميري
        COALevelIII::create([
            'name' => ['en'=> 'Ibrahim Al shumiri', 'ar' => 'ابراهيم الشيميري'], 'code' => '125017', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125018  زكريا عادل
        COALevelIII::create([
            'name' => ['en'=> 'Zakrya Adel', 'ar' => 'زكريا عادل'], 'code' => '125018', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125019  عبدالمجيد الضالع
        COALevelIII::create([
            'name' => ['en'=> 'Abdalmajed Al Dalee', 'ar' => 'عبدالمجيد الضالع'], 'code' => '125019', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125020  محمد عثمان
        COALevelIII::create([
            'name' => ['en'=> 'Mohammad Othman', 'ar' => 'محمد عثمان'], 'code' => '125020', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125021  أكمل سرفراز
        COALevelIII::create([
            'name' => ['en'=> 'Akmal Servaraz', 'ar' => 'أكمل سرفراز'], 'code' => '125021', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125022  مجيد
        COALevelIII::create([
            'name' => ['en'=> 'Majeed', 'ar' => 'مجيد'], 'code' => '125022', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125023  مدني عبدالله علي
        COALevelIII::create([
            'name' => ['en'=> 'Madni Abdullah Ali', 'ar' => 'مدني عبدالله علي'], 'code' => '125023', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125024  يعقوب
        COALevelIII::create([
            'name' => ['en'=> 'Yakoub', 'ar' => 'يعقوب'], 'code' => '125024', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125025  ماجد الحكمي
        COALevelIII::create([
            'name' => ['en'=> 'Majed Al Hakami', 'ar' => 'ماجد الحكمي'], 'code' => '125025', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125026  طاهر
        COALevelIII::create([
            'name' => ['en'=> 'Taher', 'ar' => 'طاهر'], 'code' => '125026', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125027  أحمد صالح
        COALevelIII::create([
            'name' => ['en'=> 'Ahmad Saleh', 'ar' => 'أحمد صالح'], 'code' => '125027', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125028  أبو شادي
        COALevelIII::create([
            'name' => ['en'=> 'Abu Shadi', 'ar' => 'أبو شادي'], 'code' => '125028', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125029  عبدالله
        COALevelIII::create([
            'name' => ['en'=> 'Abdullah', 'ar' => 'عبدالله'], 'code' => '125029', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125030  مصطفى
        COALevelIII::create([
            'name' => ['en'=> 'Mostafa', 'ar' => 'مصطفى'], 'code' => '125030', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125031  فخري
        COALevelIII::create([
            'name' => ['en'=> 'Fakhri', 'ar' => 'فخري'], 'code' => '125031', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125032  نادر
        COALevelIII::create([
            'name' => ['en'=> 'Nader', 'ar' => 'نادر'], 'code' => '125032', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125033  محمد نجيب
        COALevelIII::create([
            'name' => ['en'=> 'Mohammad Najeeb', 'ar' => 'محمد نجيب'], 'code' => '125033', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125034  بتول جمعة
        COALevelIII::create([
            'name' => ['en'=> 'Batoul Jomaa', 'ar' => 'بتول جمعة'], 'code' => '125034', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125035  مانع
        COALevelIII::create([
            'name' => ['en'=> 'Manee', 'ar' => 'مانع'], 'code' => '125035', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125036  محمد ناجي
        COALevelIII::create([
            'name' => ['en'=> 'Mohammad Najy', 'ar' => 'محمد ناجي'], 'code' => '125036', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125037  مصطفى صلاح
        COALevelIII::create([
            'name' => ['en'=> 'Mostafa Salah', 'ar' => 'مصطفى صلاح'], 'code' => '125037', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125038  عبدالناصر
        COALevelIII::create([
            'name' => ['en'=> 'Abdulnasser', 'ar' => 'عبدالناصر'], 'code' => '125038', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125039  محمد عبدالحي
        COALevelIII::create([
            'name' => ['en'=> 'Mohammad Abdulhai', 'ar' => 'محمد عبدالحي'], 'code' => '125039', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125040  محمد مدني
        COALevelIII::create([
            'name' => ['en'=> 'Mohammad Madani', 'ar' => 'محمد مدني'], 'code' => '125040', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125041  أسماء ناصر
        COALevelIII::create([
            'name' => ['en'=> 'Asmaa Naser', 'ar' => 'أسماء ناصر'], 'code' => '125041', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125042 أميرة نجار
        COALevelIII::create([
            'name' => ['en'=> 'Amera Najjar' ,'ar' => 'أميرة نجار'], 'code' => '125042', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125043 أميرة عبدالحي
        COALevelIII::create([
            'name' => ['en'=> 'Amera Abdulhai', 'ar' => 'أميرة عبدالحي'], 'code' => '125043', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125044 بسام مدخل بيانات
        COALevelIII::create([
            'name' => ['en'=> 'Bassam Data Entry', 'ar' => 'بسام مدخل بيانات'], 'code' => '125044', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125045 وائل الحكمي
        COALevelIII::create([
            'name' => ['en'=> 'Wael Al Hakami', 'ar' => 'وائل الحكمي'], 'code' => '125045', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125046 أسعد
        COALevelIII::create([
            'name' => ['en'=> 'Assaad', 'ar' => 'أسعد'], 'code' => '125046', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125047 هيفا دوخي
        COALevelIII::create([
            'name' => ['en'=> 'haifa Dhokhi', 'ar' => 'هيفا دوخي'], 'code' => '125047', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125048 ذ. رواتب وأجور سائقي الدراجات
        COALevelIII::create([
            'name' => ['en'=> 'Salaries and wages of bike drivers', 'ar' => 'ذ. رواتب وأجور سائقي الدراجات'], 'code' => '125048', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125049 أحمد السراج
        COALevelIII::create([
            'name' => ['en'=> 'Ahmad Al Seraj', 'ar' => 'أحمد السراج'], 'code' => '125049', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125050 محمد الياس
        COALevelIII::create([
            'name' => ['en'=> 'Mohammad Elias', 'ar' => 'محمد الياس'], 'code' => '125050', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125051 محمد نور العبيد
        COALevelIII::create([
            'name' => ['en'=> 'Mohammad Nour AlObeed', 'ar' => 'محمد نور العبيد'], 'code' => '125051', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125052 فوتوغرافر عبدالاله
        COALevelIII::create([
            'name' => ['en'=> 'Abdullelah Photographer', 'ar' => 'فوتوغرافر عبدالاله'], 'code' => '125052', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125053 ابراهيم السوداني
        COALevelIII::create([
            'name' => ['en'=> 'Ibrahim al sudani', 'ar' => 'ابراهيم السوداني'], 'code' => '125053', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125054 أمجد أبو العلا
        COALevelIII::create([
            'name' => ['en'=> 'Amjad Abu alala', 'ar' => 'أمجد أبو العلا'], 'code' => '125054', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125055 محمد أبو جاد
        COALevelIII::create([
            'name' => ['en'=> 'Mohammad Abu Jad', 'ar' => 'محمد أبو جاد'], 'code' => '125055', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125056 راضي طاهر
        COALevelIII::create([
            'name' => ['en'=> 'Radi Taher', 'ar' => 'راضي طاهر'], 'code' => '125056', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125057 محمد عبدالرحمن
        COALevelIII::create([
            'name' => ['en'=> 'Mohammad Abdulrhman', 'ar' => 'محمد عبدالرحمن'], 'code' => '125057', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125058 عدنان سعيد
        COALevelIII::create([
            'name' => ['en'=> 'Radi Taher', 'ar' => 'عدنان سعيد'], 'code' => '125058', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125059 عبدالعزيز فهمي
        COALevelIII::create([
            'name' => ['en'=> 'Abdulaziz fehmi', 'ar' => 'عبدالعزيز فهمي'], 'code' => '125059', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125060 مالك الغزاوي
        COALevelIII::create([
            'name' => ['en'=> 'Malek Ghazawi', 'ar' => 'مالك الغزاوي'], 'code' => '125060', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125061 محمد غميرة
        COALevelIII::create([
            'name' => ['en'=> 'Mohammad Ghomyra', 'ar' => 'محمد غميرة'], 'code' => '125061', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125062 علي حسين
        COALevelIII::create([
            'name' => ['en'=> 'Ali Husein', 'ar' => 'علي حسين'], 'code' => '125062', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125063 قصي عبد الحي
        COALevelIII::create([
            'name' => ['en'=> 'Qusai AbdulHai', 'ar' => 'قصي عبد الحي'], 'code' => '125063', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125064 كريشنا باجي
        COALevelIII::create([
            'name' => ['en'=> 'kreshna baji', 'ar' => 'كريشنا باجي'], 'code' => '125064', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125065 سيدرة الداهوك
        COALevelIII::create([
            'name' => ['en'=> 'Sedra AlDahok', 'ar' => 'سيدرة الداهوك'], 'code' => '125065', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125066 مريم شحادة
        COALevelIII::create([
            'name' => ['en'=> 'Mariam Shehada', 'ar' => 'مريم شحادة'], 'code' => '125066', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125067 محمد الحريري
        COALevelIII::create([
            'name' => ['en'=> 'Mohammad Hariri', 'ar' => 'محمد الحريري'], 'code' => '125067', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125068 نغم عيروطة
        COALevelIII::create([
            'name' => ['en'=> 'Nagham Airota', 'ar' => 'نغم عيروطة'], 'code' => '125068', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125069 رنيم سالم عبدالله
        COALevelIII::create([
            'name' => ['en'=> 'Ranem Salem Abdullah', 'ar' => 'رنيم سالم عبدالله'], 'code' => '125069', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125070 صالح الطيب سليمان
        COALevelIII::create([
            'name' => ['en'=> 'Saleh Altaeb Suleiman', 'ar' => 'صالح الطيب سليمان'], 'code' => '125070', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125071 عبدالرحمن كيلاني
        COALevelIII::create([
            'name' => ['en'=> 'Abdulrhman Kelani', 'ar' => 'عبدالرحمن كيلاني'], 'code' => '125071', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125072 عبدالرحمن أحمد محاسب
        COALevelIII::create([
            'name' => ['en'=> 'Abdulrhman Ahmad Accountant', 'ar' => 'عبدالرحمن أحمد محاسب'], 'code' => '125072', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125073 طاارق مريم
        COALevelIII::create([
            'name' => ['en'=> 'Tarek Mariam', 'ar' => 'طاارق مريم'], 'code' => '125073', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125074 عبدالرحمن حسين
        COALevelIII::create([
            'name' => ['en'=> 'Abd Alrhman Husein', 'ar' => 'عبدالرحمن حسين'], 'code' => '125074', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125075 عمر علي تسويق
        COALevelIII::create([
            'name' => ['en'=> 'Omar Ali marketing', 'ar' => 'عمر علي تسويق'], 'code' => '125075', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125076 عبدالرحمن علوش
        COALevelIII::create([
            'name' => ['en'=> 'Abdulrhman Alosh', 'ar' => 'عبدالرحمن علوش'], 'code' => '125076', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125077 عبيدة سليمان
        COALevelIII::create([
            'name' => ['en'=> 'Obaida Suleiman', 'ar' => 'عبيدة سليمان'], 'code' => '125077', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
        ///////////// 125078 ايات بكري
        COALevelIII::create([
            'name' => ['en'=> 'Ayat Bakri', 'ar' => 'ايات بكري'], 'code' => '125078', 'coa_i_i_id' => $coa_employee_receivables->id
        ]);
##################################################عهد الموظفين#####################################################################################
        //////// 126 عهد الموظفين
        $coa_staff_custody = COALevelII::create([
            'name' => ['en'=> 'Staff custody', 'ar' => 'عهد الموظفين'], 'code' => '126', 'coa_i_id' => $coa_current_assets->id
        ]);

        ///////////// 126001 عهدة أمجد أبو العلا
        COALevelIII::create([
            'name' => ['en'=> 'The custody of Amjad Abu Alala', 'ar' => 'عهدة أمجد أبو العلا'], 'code' => '126001', 'coa_i_i_id' => $coa_staff_custody->id
        ]);
        ///////////// 126002 عهدة يعقوب الدوسري
        COALevelIII::create([
            'name' => ['en'=> 'The custody of Yakoub Aldosari', 'ar' => 'عهدة يعقوب الدوسري'], 'code' => '126002', 'coa_i_i_id' => $coa_staff_custody->id
        ]);
        ///////////// 126003 عهدة عبدالمجيد الحكمي
        COALevelIII::create([
            'name' => ['en'=> 'The custody of AbdAlmajed AlHakami', 'ar' => 'عهدة عبدالمجيد الحكمي'], 'code' => '126003', 'coa_i_i_id' => $coa_staff_custody->id
        ]);
        ///////////// 126004 عهدة راضي طاهر
        COALevelIII::create([
            'name' => ['en'=> 'The custody of Radi Taher', 'ar' => 'عهدة راضي طاهر'], 'code' => '126004', 'coa_i_i_id' => $coa_staff_custody->id
        ]);
        ///////////// 126005 عهدة فخري النجار
        COALevelIII::create([
            'name' => ['en'=> 'The custody of Fakhri Alnajjar', 'ar' => 'عهدة فخري النجار'], 'code' => '126005', 'coa_i_i_id' => $coa_staff_custody->id
        ]);
        ///////////// 126006 عهدة عبدالعزيز
        COALevelIII::create([
            'name' => ['en'=> 'The custody of AbdulAziz', 'ar' => 'عهدة عبدالعزيز'], 'code' => '126006', 'coa_i_i_id' => $coa_staff_custody->id
        ]);
        ///////////// 126007 عهدة عبدالرحمن الصوفي
        COALevelIII::create([
            'name' => ['en'=> 'The custody of Abdulrhman AlSofi', 'ar' => 'عهدة عبدالرحمن الصوفي'], 'code' => '126007', 'coa_i_i_id' => $coa_staff_custody->id
        ]);
        ///////////// 126008 عهدة عبدالناصر
        COALevelIII::create([
            'name' => ['en'=> 'The custody of Abdulnasser', 'ar' => 'عهدة عبدالناصر'], 'code' => '126008', 'coa_i_i_id' => $coa_staff_custody->id
        ]);
        ///////////// 126009 عهدة زكريا عادل
        COALevelIII::create([
            'name' => ['en'=> 'The custody of Zakrya Adel', 'ar' => 'عهدة زكريا عادل'], 'code' => '126009', 'coa_i_i_id' => $coa_staff_custody->id
        ]);
        ///////////// 126010 عهدة ثاقب
        COALevelIII::create([
            'name' => ['en'=> 'The custody of Zakrya Adel', 'ar' => 'عهدة ثاقب'], 'code' => '126010', 'coa_i_i_id' => $coa_staff_custody->id
        ]);
        ///////////// 126011 عهدة ابراهيم الشميري
        COALevelIII::create([
            'name' => ['en'=> 'The custody of Ibrahim Al shomiri', 'ar' => 'عهدة ابراهيم الشميري'], 'code' => '126011', 'coa_i_i_id' => $coa_staff_custody->id
        ]);
        ///////////// 126012 فاضي
        COALevelIII::create([
            'name' => ['en'=> 'Empty', 'ar' => 'فاضي'], 'code' => '126012', 'coa_i_i_id' => $coa_staff_custody->id
        ]);
        ///////////// 126013 عهدة طاهر
        COALevelIII::create([
            'name' => ['en'=> 'The custody of Taher', 'ar' => 'عهدة طاهر'], 'code' => '126013', 'coa_i_i_id' => $coa_staff_custody->id
        ]);
        ///////////// 126014 عهدة مانع
        COALevelIII::create([
            'name' => ['en'=> 'The custody of Manee', 'ar' => 'عهدة مانع'], 'code' => '126014', 'coa_i_i_id' => $coa_staff_custody->id
        ]);
        ///////////// 126015 عهدة موظفين اجمالي
        COALevelIII::create([
            'name' => ['en'=> 'The custody of employees total', 'ar' => 'عهدة موظفين اجمالي'], 'code' => '126015', 'coa_i_i_id' => $coa_staff_custody->id
        ]);
        ///////////// 126016 عهدة علي حسين
        COALevelIII::create([
            'name' => ['en'=> 'The custody of Ali Husein', 'ar' => 'عهدة علي حسين'], 'code' => '126016', 'coa_i_i_id' => $coa_staff_custody->id
        ]);

########################################################الاقامات###########################################################################
        //////// 127 الاقامات
        $coa_residencies = COALevelII::create([
            'name' => ['en'=> 'Residencies', 'ar' => 'الاقامات'], 'code' => '127', 'coa_i_id' => $coa_current_assets->id
        ]);

        ///////////// 127001 اقامة أميرة عبدالحي
        COALevelIII::create([
            'name' => ['en'=> 'Amera Abdulhai Residence', 'ar' => 'اقامة أميرة عبدالحي'], 'code' => '127001', 'coa_i_i_id' => $coa_residencies->id
        ]);
        ///////////// 127002 اقامة هيفا دوخي
        COALevelIII::create([
            'name' => ['en'=> 'Haifa Dokhi Residence', 'ar' => 'اقامة هيفا دوخي'], 'code' => '127002', 'coa_i_i_id' => $coa_residencies->id
        ]);
        ///////////// 127003 اقامة فخري نجار
        COALevelIII::create([
            'name' => ['en'=> 'Fakhri al najjar Residence', 'ar' => 'اقامة فخري نجار'], 'code' => '127003', 'coa_i_i_id' => $coa_residencies->id
        ]);
        ///////////// 127004 اقامة أكمل
        COALevelIII::create([
            'name' => ['en'=> 'Akmal Residence', 'ar' => 'اقامة أكمل'], 'code' => '127004', 'coa_i_i_id' => $coa_residencies->id
        ]);
        ///////////// 127005 اقامة احسان الباكستاني
        COALevelIII::create([
            'name' => ['en'=> 'Ehsan al bakstani Residence', 'ar' => 'اقامة احسان الباكستاني'], 'code' => '127005', 'coa_i_i_id' => $coa_residencies->id
        ]);
        ///////////// 127006 اعارة ابراهيم الشميري
        COALevelIII::create([
            'name' => ['en'=> 'Ibrahim Al-Shamiri Loan', 'ar' => 'اعارة ابراهيم الشميري'], 'code' => '127006', 'coa_i_i_id' => $coa_residencies->id
        ]);
        ///////////// 127007 اقامة بتول جمعة
        COALevelIII::create([
            'name' => ['en'=> 'Batoul Joumaa Residence', 'ar' => 'اقامة بتول جمعة'], 'code' => '127007', 'coa_i_i_id' => $coa_residencies->id
        ]);
        ///////////// 127008 اقامة مصطفى العبدالله
        COALevelIII::create([
            'name' => ['en'=> 'Mostafa AlAbdullah Residence', 'ar' => 'اقامة مصطفى العبدالله'], 'code' => '127008', 'coa_i_i_id' => $coa_residencies->id
        ]);
        ///////////// 127009 تيكت أمير محمود
        COALevelIII::create([
            'name' => ['en'=> 'Ticket Amir Mahmoud', 'ar' => 'تيكت أمير محمود'], 'code' => '127009', 'coa_i_i_id' => $coa_residencies->id
        ]);
##########################################################################################################################################
        //////// 128 حساب فارغ
        COALevelII::create([
            'name' => ['en'=> 'Empty account', 'ar' => 'حساب فارغ'], 'code' => '128', 'coa_i_id' => $coa_current_assets->id
        ]);
        //////// 129  2حساب فارغ
        COALevelII::create([
            'name' => ['en'=> 'Empty account 2', 'ar' => '2 حساب فارغ'], 'code' => '129', 'coa_i_id' => $coa_current_assets->id
        ]);
/***********************************************الأموال الجاهزة ***************************************************************************** */
            // 13 الأموال الجاهزة
            $coa_ready_money =COALevelI::create([
                'name' => ['en'=> 'Ready money', 'ar' => 'الأموال الجاهزة'], 'code' => '13', 'coa_id' => $coa_assets->id
            ]);
        //////// 131  الصندوق/ حساب الدراجات
        COALevelII::create([
            'name' => ['en'=> 'Fund/bicycle account', 'ar' => 'الصندوق/ حساب الدراجات '], 'code' => '131', 'coa_i_id' => $coa_ready_money->id
        ]);
        //////// 132  (18974350)مصرف أبوظبي الاسلامي
        COALevelII::create([
            'name' => ['en'=> 'Abu Dhabi Islamic Bank', 'ar' => ' (18974350)مصرف أبوظبي الاسلامي '], 'code' => '132', 'coa_i_id' => $coa_ready_money->id
        ]);
        //////// 133  الصندوق/ حساب التجار
        COALevelII::create([
            'name' => ['en'=> 'Fund/merchants account', 'ar' => 'الصندوق/ حساب التجار'], 'code' => '133', 'coa_i_id' => $coa_ready_money->id
        ]);


//////////////////////////////////////////////////المطاليب/////////////////////////////////////////////////////////////////////////

        //المطاليب  2
        $coa_liabilities = COA::create(['name' => ['ar' => 'الخصوم', 'en' => 'liabilities'], 'code' => '2', 'trial_balance_id' => '1']);

/*********************************************** المطاليب الثابتة ***************************************************************************** */
        // 21 المطاليب الثابتة
        $coa_fixed_liabilities = COALevelI::create([
            'name' => ['en'=> 'Fixed liabilities', 'ar' => 'خصوم ثابتة'], 'code' => '21', 'coa_id' => $coa_liabilities->id
        ]);
####################################################رأس المال#######################################################################################
        //////// 211  رأس المال
        $coa_capital = COALevelII::create([
            'name' => ['en'=> 'capital', 'ar' => 'رأس المال'], 'code' => '211', 'coa_i_id' => $coa_fixed_liabilities->id
        ]);
        ///////////// 21101 رأس مال الشريك 1
        COALevelIII::create([
            'name' => ['en'=> "Partner's capital", 'ar' => 'رأس مال الشريك 1'], 'code' => '21101', 'coa_i_i_id' => $coa_capital->id
        ]);
############################################################################################################################################
        //////// 212  القروض
        COALevelII::create([
            'name' => ['en'=> 'Loans', 'ar' => 'القروض'], 'code' => '212', 'coa_i_id' => $coa_fixed_liabilities->id
        ]);
        //////// 213  جاري الشركاء
        COALevelII::create([
            'name' => ['en'=> 'Partners current', 'ar' => 'جاري الشركاء'], 'code' => '213', 'coa_i_id' => $coa_fixed_liabilities->id
        ]);
        //////// 214  جاري الشريك بسام
        COALevelII::create([
            'name' => ['en'=> 'Bassam Partner current', 'ar' => 'جاري الشريك بسام'], 'code' => '214', 'coa_i_id' => $coa_fixed_liabilities->id
        ]);
        //////// 215  جاري الشريك أبو صالح
        COALevelII::create([
            'name' => ['en'=> 'Abu Saleh Partner current', 'ar' => 'جاري الشريك أبو صالح'], 'code' => '215', 'coa_i_id' => $coa_fixed_liabilities->id
        ]);
/*********************************************** المطاليب المتداولة ***************************************************************************** */
        //22 المطاليب المتداولة
        $coa_current_liabilities = COALevelI::create([
            'name' => ['en'=> 'Current liabilities', 'ar' => 'خصوم متداولة'], 'code' => '22', 'coa_id' => $coa_liabilities->id
        ]);
############################################################ الموردون ###################################################################################
        //////// 221  الموردون
        $coa_suppliers =COALevelII::create([
            'name' => ['en'=> 'Suppliers', 'ar' => 'الموردون'], 'code' => '221', 'coa_i_id' => $coa_current_liabilities->id
        ]);

        ///////////// 221001 الفايز للخرائط والرسومات
        COALevelIII::create([
            'name' => ['en'=> "Al Fayez Maps and Drawings", 'ar' => 'الفايز للخرائط والرسومات '], 'code' => '221001', 'coa_i_i_id' => $coa_suppliers->id
        ]);
        ///////////// 221002 دالومال للتعبئة الصناعية
        COALevelIII::create([
            'name' => ['en'=> "DHALUMAL PACKING IND", 'ar' => 'دالومال للتعبئة الصناعية '], 'code' => '221002', 'coa_i_i_id' => $coa_suppliers->id
        ]);
        ///////////// 221003 شركة الشحن
        COALevelIII::create([
            'name' => ['en'=> "Shipping company", 'ar' => 'شركة الشحن '], 'code' => '221003', 'coa_i_i_id' => $coa_suppliers->id
        ]);
        ///////////// 221004 رافال بروبيريتز
        COALevelIII::create([
            'name' => ['en'=> "RAFAL PROPERTIES", 'ar' => 'رافال بروبيريتز '], 'code' => '221004', 'coa_i_i_id' => $coa_suppliers->id
        ]);
        ///////////// 221005 مسلم المزروعي - ايجار سكن الموظفين
        COALevelIII::create([
            'name' => ['en'=> "Muslim Al Mazroui - renting employee housing", 'ar' => 'مسلم المزروعي - ايجار سكن الموظفين '], 'code' => '221005', 'coa_i_i_id' => $coa_suppliers->id
        ]);
        ///////////// 221006 الزرينا للشحن
        COALevelIII::create([
            'name' => ['en'=> "Zarina Shipping", 'ar' => 'الزرينا للشحن '], 'code' => '221006', 'coa_i_i_id' => $coa_suppliers->id
        ]);
#########################################################دائنون مختلفون################################################################################
        //////// 222  دائنون مختلفون
        $coa_various_creditors = COALevelII::create([
            'name' => ['en'=> 'Various creditors', 'ar' => 'دائنون مختلفون'], 'code' => '222', 'coa_i_id' => $coa_current_liabilities->id
        ]);
        ///////////// 222001 رواتب مستحقة
        COALevelIII::create([
            'name' => ['en'=> "due Salaries ", 'ar' => 'رواتب مستحقة '], 'code' => '222001', 'coa_i_i_id' => $coa_various_creditors->id
        ]);
        ///////////// 222002 عمولات مندوبين مستحقة
        COALevelIII::create([
            'name' => ['en'=> "due representatives commissions ", 'ar' => 'عمولات مندوبين مستحقة '], 'code' => '222002', 'coa_i_i_id' => $coa_various_creditors->id
        ]);
        ///////////// 222003 عمولات مسوقين مستحقة
        COALevelIII::create([
            'name' => ['en'=> "due Marketing commissions ", 'ar' => 'عمولات مسوقين مستحقة '], 'code' => '222003', 'coa_i_i_id' => $coa_various_creditors->id
        ]);
        ///////////// 222004 مصاريف هاتف مستحقة
        COALevelIII::create([
            'name' => ['en'=> "due Telephone charges ", 'ar' => 'مصاريف هاتف مستحقة '], 'code' => '222004', 'coa_i_i_id' => $coa_various_creditors->id
        ]);
        ///////////// 222005 مصاريف كهرباء وماء مستحقة
        COALevelIII::create([
            'name' => ['en'=> "due water and electricity charges ", 'ar' => 'مصاريف كهرباء وماء مستحقة '], 'code' => '222005', 'coa_i_i_id' => $coa_various_creditors->id
        ]);
        ///////////// 222006 مخالفات مرورية مستحقة
        COALevelIII::create([
            'name' => ['en'=> "Due traffic violations ", 'ar' => 'مخالفات مرورية مستحقة '], 'code' => '222006', 'coa_i_i_id' => $coa_various_creditors->id
        ]);
        ///////////// 222007 شركة توصيل الغربية
        COALevelIII::create([
            'name' => ['en'=> "Due traffic violations ", 'ar' => 'شركة توصيل الغربية '], 'code' => '222007', 'coa_i_i_id' => $coa_various_creditors->id
        ]);
        ///////////// 222008 فرع أبو ظبي
        COALevelIII::create([
            'name' => ['en'=> "Abu Dhabi branch ", 'ar' => 'فرع أبو ظبي '], 'code' => '222008', 'coa_i_i_id' => $coa_various_creditors->id
        ]);
        ///////////// 222009 شركة الجزيرة لتدقيق الحسابات
        COALevelIII::create([
            'name' => ['en'=> "Al Jazeera Auditing Company ", 'ar' => 'شركة الجزيرة لتدقيق الحسابات '], 'code' => '222009', 'coa_i_i_id' => $coa_various_creditors->id
        ]);
        ///////////// 222010 شركة توصيل القوع والوقن
        COALevelIII::create([
            'name' => ['en'=> "Al Jazeera Auditing Company ", 'ar' => 'شركة توصيل القوع والوقن '], 'code' => '222010', 'coa_i_i_id' => $coa_various_creditors->id
        ]);
        ///////////// 222012 الوحدة لمراجعة الحسابات - معاوية
        COALevelIII::create([
            'name' => ['en'=> "Auditing Unit - Muawiyah ", 'ar' => 'الوحدة لمراجعة الحسابات - معاوية '], 'code' => '222012', 'coa_i_i_id' => $coa_various_creditors->id
        ]);
        ///////////// 222013 أتعاب تدقيق حسابات مستحقة
        COALevelIII::create([
            'name' => ['en'=> "due Auditing fees", 'ar' => 'أتعاب تدقيق حسابات مستحقة '], 'code' => '222013', 'coa_i_i_id' => $coa_various_creditors->id
        ]);
############################################################مجمع اهتلاك الأصول الثابتة#####################################################################################
        //////// 223  مجمع اهتلاك الأصول الثابتة
        $Accumulated_fixed_asset_depreciation = COALevelII::create([
            'name' => ['en'=> 'Accumulated fixed asset depreciation', 'ar' => 'مجمع اهتلاك الأصول الثابتة'], 'code' => '223', 'coa_i_id' => $coa_current_liabilities->id
        ]);


        ///////////// 223001 مجمع اهتلاك الاثاث
        COALevelIII::create([
            'name' => ['en'=> "Furniture depreciation compound", 'ar' => 'مجمع اهتلاك الاثاث '], 'code' => '223001', 'coa_i_i_id' => $Accumulated_fixed_asset_depreciation->id
        ]);
        ///////////// 223002 مجمع اهتلاك السيارات
        COALevelIII::create([
            'name' => ['en'=> "cars depreciation compound", 'ar' => 'مجمع اهتلاك السيارات '], 'code' => '223002', 'coa_i_i_id' => $Accumulated_fixed_asset_depreciation->id
        ]);
        ///////////// 223003 مجمع اهتلاك الدراجات النارية
        COALevelIII::create([
            'name' => ['en'=> "Motorcycle depreciation compound", 'ar' => 'مجمع اهتلاك الدراجات النارية '], 'code' => '223003', 'coa_i_i_id' => $Accumulated_fixed_asset_depreciation->id
        ]);
        ///////////// 223004 مجمع اهتلاك أجهزة الكمبيوتر وسوفت وير
        COALevelIII::create([
            'name' => ['en'=> "Software and computers depreciation compound", 'ar' => 'مجمع اهتلاك أجهزة الكمبيوتر وسوفت وير '], 'code' => '223004', 'coa_i_i_id' => $Accumulated_fixed_asset_depreciation->id
        ]);
        ///////////// 223005 مجمع اهتلاك العدد والأدوات
        COALevelIII::create([
            'name' => ['en'=> "Tools depreciation compound", 'ar' => 'مجمع اهتلاك العدد والأدوات '], 'code' => '223005', 'coa_i_i_id' => $Accumulated_fixed_asset_depreciation->id
        ]);
        ///////////// 223006 مجمع اهتلاك مصاريف التأسيس
        COALevelIII::create([
            'name' => ['en'=> "Accumulated depreciation of establishment expenses", 'ar' => 'مجمع اهتلاك مصاريف التأسيس '], 'code' => '223006', 'coa_i_i_id' => $Accumulated_fixed_asset_depreciation->id
        ]);
####################################################################################################################################################
        //////// 224  أرباح وخسائر السنوات السابقة
        COALevelII::create([
            'name' => ['en'=> 'Profits and losses of previous years', 'ar' => 'أرباح وخسائر السنوات السابقة'], 'code' => '224', 'coa_i_id' => $coa_current_liabilities->id
        ]);


///////////////////////////////////////////////صافي المشتريات////////////////////////////////////////////////////////////////////////
        // صافي المشتريات 3
        $coa_net_purchases = COA::create(['name' => ['ar' => 'صافي المشتريات', 'en' => 'Net purchases'], 'code' => '3', 'trial_balance_id' => '2']);

/************************************************ المشتريات ***************************************************************************** */
        // 31 المشتريات
        COALevelI::create([
            'name' => ['en'=> 'purchases', 'ar' => 'المشتريات'], 'code' => '31', 'coa_id' => $coa_net_purchases->id
        ]);
/************************************************ مرتجع المشتريات ***************************************************************************** */

        // 32 مرتجع المشتريات
        COALevelI::create([
            'name' => ['en'=> 'Purchase returns', 'ar' => 'مرتجع المشتريات'], 'code' => '32', 'coa_id' => $coa_net_purchases->id
        ]);
/************************************************ مصاريف نقل المشتريات ***************************************************************************** */

        // 33 مصاريف نقل المشتريات
        COALevelI::create([
            'name' => ['en'=> 'Purchase transportation expenses', 'ar' => 'مصاريف نقل المشتريات'], 'code' => '33', 'coa_id' => $coa_net_purchases->id
        ]);
/************************************************ الحسم المكتسب ***************************************************************************** */
        // 34  الحسم المكتسب
        COALevelI::create([
            'name' => ['en'=> 'Earned discount', 'ar' => 'الحسم المكتسب'], 'code' => '34', 'coa_id' => $coa_net_purchases->id
        ]);

/////////////////////////////////////////////////صافي المبيعات////////////////////////////////////////////////////////////////////////////////

        // صافي المبيعات 4
        $coa_net_sales = COA::create(['name' => ['ar' => 'صافي المبيعات', 'en' => 'Net sales'], 'code' => '4', 'trial_balance_id' => '2']);

/************************************************ مبيعات سيارات التوصيل ***************************************************************************** */

        // 41 مبيعات سيارات التوصيل
        COALevelI::create([
            'name' => ['en'=> 'Delivery vehicle sales', 'ar' => 'مبيعات سيارات التوصيل'], 'code' => '41', 'coa_id' => $coa_net_sales->id
        ]);

/************************************************ مرتجع المبيعات ***************************************************************************** */
        // مرتجع المبيعات 42
        COALevelI::create([
            'name' => ['en'=> 'Sales returns', 'ar' => 'مرتجع المبيعات'], 'code' => '42', 'coa_id' => $coa_net_sales->id
        ]);
/************************************************ الحسم الممنوح ***************************************************************************** */
        // 43 الحسم الممنوح
        COALevelI::create([
            'name' => ['en'=> 'discount granted', 'ar' => 'الحسم الممنوح'], 'code' => '43', 'coa_id' => $coa_net_sales->id
        ]);
/************************************************ مبيعات الدراجات النارية ***************************************************************************** */
        // 44 مبيعات الدراجات النارية
        COALevelI::create([
            'name' => ['en'=> 'Motorcycle sales', 'ar' => 'مبيعات الدراجات النارية'], 'code' => '44', 'coa_id' => $coa_net_sales->id
        ]);

///////////////////////////////////////////////////المصاريف/////////////////////////////////////////////////////////////////////

        //  المصاريف 5
        $coa_expenses = COA::create(['name' => ['ar' => 'المصاريف', 'en' => 'expenses'], 'code' => '5', 'trial_balance_id' => '2']);

/************************************************ رواتب وأجور ***************************************************************************** */

        //رواتب وأجور 501
        $coa_salarues_and_wages = COALevelI::create([
            'name' => ['en'=> 'Salaries and wages', 'ar' => 'رواتب وأجور'], 'code' => '501', 'coa_id' => $coa_expenses->id
        ]);

        // 501001 رواتب وأجور الادارة
        COALevelII::create([
            'name' => ['en'=> 'Salaries and wages for management', 'ar' => 'رواتب وأجور الادارة'], 'code' => '501001', 'coa_i_id' => $coa_salarues_and_wages->id
        ]);
        // 501002 رواتب وأجور مندوبين التوصيل
        COALevelII::create([
            'name' => ['en'=> 'Salaries and wages of delivery representatives', 'ar' => 'رواتب وأجور مندوبين التوصيل'], 'code' => '501002', 'coa_i_id' => $coa_salarues_and_wages->id
        ]);
        // 501003 رواتب وأجور الدراجات
        COALevelII::create([
            'name' => ['en'=> 'Bicycle salaries and wages', 'ar' => 'رواتب وأجور الدراجات'], 'code' => '501003', 'coa_i_id' => $coa_salarues_and_wages->id
        ]);
        // 501004 سلف
        COALevelII::create([
            'name' => ['en'=> 'Loans', 'ar' => 'سلف'], 'code' => '501004', 'coa_i_id' => $coa_salarues_and_wages->id
        ]);

/************************************************ كهرباء وماء ***************************************************************************** */
        // 502 كهرباء وماء
        COALevelI::create([
            'name' => ['en'=> 'electricity and water', 'ar' => 'كهرباء وماء'], 'code' => '502', 'coa_id' => $coa_expenses->id
        ]);
/************************************************ هاتف وفاكس وانترنت ***************************************************************************** */
        // 503 هاتف وفاكس وانترنت
        COALevelI::create([
            'name' => ['en'=> 'Telephone, fax and internet', 'ar' => 'هاتف وفاكس وانترنت'], 'code' => '503', 'coa_id' => $coa_expenses->id
        ]);
/************************************************ اكراميات وهدايا ***************************************************************************** */
        // 504 اكراميات وهدايا
        COALevelI::create([
            'name' => ['en'=> 'tips and gifts', 'ar' => 'اكراميات وهدايا'], 'code' => '504', 'coa_id' => $coa_expenses->id
        ]);
/************************************************ نقل وانتقال ***************************************************************************** */
        //505 نقل وانتقال
        COALevelI::create([
            'name' => ['en'=> 'Transfer and transmission', 'ar' => 'نقل وانتقال'], 'code' => '505', 'coa_id' => $coa_expenses->id
        ]);
/************************************************ وقود ومحروقات وسيارات ***************************************************************************** */
        // 506 وقود ومحروقات وسيارات
        COALevelI::create([
            'name' => ['en'=> 'Fuel, fuel and cars', 'ar' => 'وقود ومحروقات وسيارات'], 'code' => '506', 'coa_id' => $coa_expenses->id
        ]);
/************************************************ صيانة وقطع غيار ***************************************************************************** */
        // 507 صيانة وقطع غيار
        COALevelI::create([
            'name' => ['en'=> 'Maintenance and spare parts', 'ar' => 'صيانة وقطع غيار'], 'code' => '507', 'coa_id' => $coa_expenses->id
        ]);
/************************************************ قرطاسية ومطبوعات ***************************************************************************** */
        // 508 قرطاسية ومطبوعات
        COALevelI::create([
            'name' => ['en'=> 'Stationery and publications', 'ar' => 'قرطاسية ومطبوعات'], 'code' => '508', 'coa_id' => $coa_expenses->id
        ]);
/************************************************ زيوت وشحوم ***************************************************************************** */
        // 509 زيوت وشحوم
        COALevelI::create([
            'name' => ['en'=> 'Oils and greases', 'ar' => 'زيوت وشحوم'], 'code' => '509', 'coa_id' => $coa_expenses->id
        ]);
/************************************************ مصاريف متفرقة ***************************************************************************** */
        // 510 مصاريف متفرقة
        COALevelI::create([
            'name' => ['en'=> 'Miscellaneous expenses', 'ar' => 'مصاريف متفرقة'], 'code' => '510', 'coa_id' => $coa_expenses->id
        ]);
/************************************************ غسيل وتلميع سيارات ***************************************************************************** */
        // 511 غسيل وتلميع سيارات
        COALevelI::create([
            'name' => ['en'=> 'Car washing and polishing', 'ar' => 'غسيل وتلميع سيارات'], 'code' => '511', 'coa_id' => $coa_expenses->id
        ]);
/************************************************ سالك للسيارات ***************************************************************************** */
        // 512 سالك للسيارات
        COALevelI::create([
            'name' => ['en'=> 'Salik Cars', 'ar' => 'سالك للسيارات'], 'code' => '512', 'coa_id' => $coa_expenses->id
        ]);
/***************************************************ايجار************************************************************************************** */
        // 513 ايجار
        COALevelI::create([
            'name' => ['en'=> 'rent', 'ar' => 'ايجار'], 'code' => '513', 'coa_id' => $coa_expenses->id
        ]);
/***************************************************مصاريف وتأمين********************************************************************************* */
        // 514 مصاريف وتأمين
        COALevelI::create([
            'name' => ['en'=> 'Expenses and insurance', 'ar' => 'مصاريف وتأمين'], 'code' => '514', 'coa_id' => $coa_expenses->id
        ]);
/**********************************************استهلاك الأثاث*********************************************************************************** */
        // 515 استهلاك الأثاث
        COALevelI::create([
            'name' => ['en'=> 'Furniture consumption', 'ar' => 'استهلاك الأثاث'], 'code' => '515', 'coa_id' => $coa_expenses->id
        ]);
/*************************************************استهلاك السيارات************************************************************************************* */
        // 516 استهلاك السيارات
        COALevelI::create([
            'name' => ['en'=> 'cars consumption', 'ar' => 'استهلاك السيارات'], 'code' => '516', 'coa_id' => $coa_expenses->id
        ]);
/***************************************************استهلاك الدراجات النارية****************************************************************************** */
        // 517 استهلاك الدراجات النارية
        COALevelI::create([
            'name' => ['en'=> 'Motorcycle consumption', 'ar' => 'استهلاك الدراجات النارية'], 'code' => '517', 'coa_id' => $coa_expenses->id
        ]);
/****************************************************استهلاك أجهزة كمبيوتر وسوفت وير*********************************************************************** */
        // 518 استهلاك أجهزة كمبيوتر وسوفت وير
        COALevelI::create([
            'name' => ['en'=> 'Consumption of computers and software', 'ar' => 'استهلاك أجهزة كمبيوتر وسوفت وير'], 'code' => '518', 'coa_id' => $coa_expenses->id
        ]);
/*****************************************************استهلاك عدد وأدوات******************************************************************* */
        // 519 استهلاك عدد وأدوات
        COALevelI::create([
            'name' => ['en'=> 'Consumption of tools', 'ar' => 'استهلاك عدد وأدوات'], 'code' => '519', 'coa_id' => $coa_expenses->id
        ]);
/*****************************************************استهلاك مصاريف التأسيس***************************************************************************** */
        // 520 استهلاك مصاريف التأسيس
        COALevelI::create([
            'name' => ['en'=> 'Amortization of establishment expenses', 'ar' => 'استهلاك مصاريف التأسيس'], 'code' => '520', 'coa_id' => $coa_expenses->id
        ]);
/*****************************************************دعاية واعلان**************************************************************************** */
        // 521 دعاية واعلان
        COALevelI::create([
            'name' => ['en'=> 'Advertising', 'ar' => 'دعاية واعلان'], 'code' => '521', 'coa_id' => $coa_expenses->id
        ]);
/***************************************************وقود ومحروقات الدرااجات********************************************************************************* */
        // 522 وقود ومحروقات الدرااجات
        COALevelI::create([
            'name' => ['en'=> 'Bicycle fuel and fuel', 'ar' => 'وقود ومحروقات الدرااجات'], 'code' => '522', 'coa_id' => $coa_expenses->id
        ]);
/*************************************************عمولات التوصيل*************************************************************************** */
        // 523 عمولات التوصيل
        COALevelI::create([
            'name' => ['en'=> 'Delivery commissions', 'ar' => 'عمولات التوصيل'], 'code' => '523', 'coa_id' => $coa_expenses->id
        ]);
/*************************************************عمولات الاستلام*********************************************************************************** */
        // 524 عمولات الاستلام
        COALevelI::create([
            'name' => ['en'=> 'Receiving commissions', 'ar' => 'عمولات الاستلام'], 'code' => '524', 'coa_id' => $coa_expenses->id
        ]);
/************************************************مصروف التأمين*************************************************************************************** */
        // 525 مصروف التأمين
        COALevelI::create([
            'name' => ['en'=> 'Insurance expense', 'ar' => 'مصروف التأمين'], 'code' => '525', 'coa_id' => $coa_expenses->id
        ]);
/************************************************رسوم بنكية******************************************************************************************* */
        // 526 رسوم بنكية
        COALevelI::create([
            'name' => ['en'=> 'Bank fees', 'ar' => 'رسوم بنكية'], 'code' => '526', 'coa_id' => $coa_expenses->id
        ]);
/**********************************************مصاريف تعبئة وتغليف****************************************************************************************** */
        // 527 مصاريف تعبئة وتغليف
        COALevelI::create([
            'name' => ['en'=> 'Packaging and wrapping expenses', 'ar' => 'مصاريف تعبئة وتغليف'], 'code' => '527', 'coa_id' => $coa_expenses->id
        ]);
/*******************************************مصاريف اقامات************************************************************************************* */
        // 528 مصاريف اقامات
        COALevelI::create([
            'name' => ['en'=> 'Accommodation expenses', 'ar' => 'مصاريف اقامات'], 'code' => '528', 'coa_id' => $coa_expenses->id
        ]);
/*******************************************مكافآت********************************************************************************************** */
        // 529 مكافآت
        COALevelI::create([
            'name' => ['en'=> 'Rewards', 'ar' => 'مكافآت'], 'code' => '529', 'coa_id' => $coa_expenses->id
        ]);
/************************************************صيانة وقطع غيار الدراجات*************************************************************************************** */
        // 530 صيانة وقطع غيار الدراجات
        COALevelI::create([
            'name' => ['en'=> 'Bicycle maintenance and spare parts', 'ar' => 'صيانة وقطع غيار الدراجات'], 'code' => '530', 'coa_id' => $coa_expenses->id
        ]);
/*************************************************مصاريف متفرقة دراجات********************************************************************************* */
        // 531 مصاريف متفرقة دراجات
        COALevelI::create([
            'name' => ['en'=> 'Miscellaneous expenses Bicycles', 'ar' => 'مصاريف متفرقة دراجات'], 'code' => '531', 'coa_id' => $coa_expenses->id
        ]);
/*****************************************************درب*********************************************************************************** */
        // 532 درب
        COALevelI::create([
            'name' => ['en'=> 'Darb', 'ar' => 'درب'], 'code' => '532', 'coa_id' => $coa_expenses->id
        ]);
/****************************************************مصاريف حكومية************************************************************************************* */
        // 533 مصاريف حكومية
        COALevelI::create([
            'name' => ['en'=> 'Governmental expenses', 'ar' => 'مصاريف حكومية'], 'code' => '533', 'coa_id' => $coa_expenses->id
        ]);
/*****************************************************خسائر عرضية********************************************************************************** */
        // 534 خسائر عرضية
        COALevelI::create([
            'name' => ['en'=> 'Accidental losses', 'ar' => 'خسائر عرضية'], 'code' => '534', 'coa_id' => $coa_expenses->id
        ]);
/************************************************************عمولة دراجات****************************************************************************************** */
        // 535 عمولة دراجات
        COALevelI::create([
            'name' => ['en'=> 'Bicycle commission', 'ar' => 'عمولة دراجات'], 'code' => '535', 'coa_id' => $coa_expenses->id
        ]);
/****************************************************************ترخيص سي************************************************************************************** */
        // 536 ترخيص سيارات
        COALevelI::create([
            'name' => ['en'=> 'Car license', 'ar' => 'ترخيص سيارات'], 'code' => '536', 'coa_id' => $coa_expenses->id
        ]);
/**************************************************************مواقف - باركينغ**************************************************************************************** */
        // 537 مواقف - باركينغ
        COALevelI::create([
            'name' => ['en'=> 'Parking - parking', 'ar' => 'مواقف - باركينغ'], 'code' => '537', 'coa_id' => $coa_expenses->id
        ]);
/******************************************************************عمولات مصرفية************************************************************************************ */
        // 538 عمولات مصرفية
        COALevelI::create([
            'name' => ['en'=> 'عمولات مصرفية', 'ar' => 'عمولات مصرفية'], 'code' => '538', 'coa_id' => $coa_expenses->id
        ]);
/**********************************************************أتعاب تدقيق حسابات******************************************************************************************** */
        // 539 أتعاب تدقيق حسابات
        COALevelI::create([
            'name' => ['en'=> 'Auditing fees', 'ar' => 'أتعاب تدقيق حسابات'], 'code' => '539', 'coa_id' => $coa_expenses->id
        ]);
/**********************************************************ديون معدومة******************************************************************************************** */
        // 540 ديون معدومة
        COALevelI::create([
            'name' => ['en'=> 'Bad debts', 'ar' => 'ديون معدومة'], 'code' => '540', 'coa_id' => $coa_expenses->id
        ]);
/************************************************************عمولة فرع أبو ظبي****************************************************************************************** */
        // 541 عمولة فرع أبو ظبي
        COALevelI::create([
            'name' => ['en'=> 'Abu Dhabi branch commission', 'ar' => 'عمولة فرع أبو ظبي'], 'code' => '541', 'coa_id' => $coa_expenses->id
        ]);
/**************************************************************مصاريف سوفت وير وبرمجة**************************************************************************************** */
        // 542 مصاريف سوفت وير وبرمجة
        COALevelI::create([
            'name' => ['en'=> 'Software and programming expenses', 'ar' => 'مصاريف سوفت وير وبرمجة'], 'code' => '542', 'coa_id' => $coa_expenses->id
        ]);
/*****************************************************************مخالفات مرورية الشركة************************************************************************************* */
        // 543 مخالفات مرورية الشركة
        COALevelI::create([
            'name' => ['en'=> 'Company traffic violations', 'ar' => 'مخالفات مرورية الشركة'], 'code' => '543', 'coa_id' => $coa_expenses->id
        ]);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // الايرادات  6
        $coa_revenues = COA::create(['name' => ['ar' => 'الإيرادات', 'en' => 'Revenues'], 'code' => '6', 'trial_balance_id' => '2']);

/*****************************************************************ايرادات مختلفة************************************************************************************* */
        // 601 ايرادات مختلفة
        COALevelI::create([
            'name' => ['en'=> 'Various revenues', 'ar' => 'ايرادات مختلفة'], 'code' => '601', 'coa_id' => $coa_revenues->id
        ]);
/*****************************************************************خصميات  ************************************************************************************* */
        // 602 خصميات
        COALevelI::create([
            'name' => ['en'=> 'Discounts', 'ar' => 'خصميات'], 'code' => '602', 'coa_id' => $coa_revenues->id
        ]);
//////////////////////////////////////////////////////////البضاعة//////////////////////////////////////////////////////////////////////////////////////////////////

        // البضاعة 7
        $coa_goods =COA::create(['name' => ['ar' => 'البضاعة', 'en' => 'goods'], 'code' => '7', 'trial_balance_id' => '2']);
/*****************************************************************بضاعة أول المدة  ************************************************************************************* */
        // 71 بضاعة أول المدة
        COALevelI::create([
            'name' => ['en'=> 'Goods for the first term', 'ar' => 'بضاعة أول المدة'], 'code' => '71', 'coa_id' => $coa_goods->id
        ]);
/*****************************************************************بضاعة اخر المدة   ************************************************************************************* */
        // بضاعة اخر المدة
        COALevelI::create([
            'name' => ['en'=> 'Goods for the end term', 'ar' => 'بضاعة اخر المدة'], 'code' => '72', 'coa_id' => $coa_goods->id
        ]);

        // COA::create(['name' => ['ar' => 'حقوق الملكية', 'en' => 'Property rights'], 'code' => '5','trial_balance_id'=>'1']);
    }
}
