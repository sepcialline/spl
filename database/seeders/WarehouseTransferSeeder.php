<?php

namespace Database\Seeders;

use App\Models\WarehouseTransfer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WarehouseTransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WarehouseTransfer::create(['branch_id' => 1, 'product_id'=>1, 'company_id'=>1,'quantity'=>1]);
        WarehouseTransfer::create(['branch_id' => 1, 'product_id'=>1,'company_id'=>1,'quantity'=>5]);
        WarehouseTransfer::create(['branch_id' => 1, 'product_id'=>1,'company_id'=>1,'quantity'=>10]);
    }
}
