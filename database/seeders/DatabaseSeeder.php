<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CarPLate;
use App\Models\ExpenseType;
use App\Models\JounalType;
use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AccountantSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RolesSeeder::class);
        // $this->call(AdminSeeder::class);
        $this->call(EmiratesSeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(TrialBalanceSeeder::class);
        $this->call(ChartOfAccountsSeeder::class);
        $this->call(VehicleTypesSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(ShipmentStatusesSeeder::class);
        $this->call(WarehouseTransferSeeder::class);
        $this->call(WarehouseOptionsSeeder::class);
        $this->call(MapSettingSeeder::class);
        $this->call(FeesTypeSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(WareHousesSeeder::class);
        $this->call(ExpenseTypeSeeder::class);
        $this->call(CarPLateSeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(JounalTypeSeeder::class);

    }
}
