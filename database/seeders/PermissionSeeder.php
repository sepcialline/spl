<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /**************** Admin ********************/

        //shopify G-1
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-shopify-show-page', 'group_id' => 1, 'group_name' => 'Shopify', 'short_name' => 'show page'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-shopify-add-merchant', 'group_id' => 1, 'group_name' => 'Shopify', 'short_name' => 'add-merchant'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-shopify-refresh', 'group_id' => 1, 'group_name' => 'Shopify', 'short_name' => 'refresh'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-shopify-config', 'group_id' => 1, 'group_name' => 'Shopify', 'short_name' => 'config'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-shopify-show', 'group_id' => 1, 'group_name' => 'Shopify', 'short_name' => 'show'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-shopify-create-shipment', 'group_id' => 1, 'group_name' => 'Shopify', 'short_name' => 'create-shipment'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-shopify-close-order', 'group_id' => 1, 'group_name' => 'Shopify', 'short_name' => 'close-order'
        ]);


        //WareHouse G-2
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-warehouse-show-page', 'group_id' => 2, 'group_name' => 'WareHouse', 'short_name' => 'show page'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-warehouse-add', 'group_id' => 2, 'group_name' => 'WareHouse', 'short_name' => 'add'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-warehouse-edit', 'group_id' => 2, 'group_name' => 'WareHouse', 'short_name' => 'edit'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-warehouse-change-status', 'group_id' => 2, 'group_name' => 'WareHouse', 'short_name' => 'change-status'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-warehouse-delete', 'group_id' => 2, 'group_name' => 'WareHouse', 'short_name' => 'delete'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-warehouse-report', 'group_id' => 2, 'group_name' => 'WareHouse', 'short_name' => 'report'
        ]);


        //Product G-3
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Product-show-page', 'group_id' => 3, 'group_name' => 'Product', 'short_name' => 'show page'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Product-add', 'group_id' => 3, 'group_name' => 'Product', 'short_name' => 'add'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Product-edit', 'group_id' => 3, 'group_name' => 'Product', 'short_name' => 'edit'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Product-delete', 'group_id' => 3, 'group_name' => 'Product', 'short_name' => 'delete'
        ]);


        //Product-details G-4
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Product-details-showPage', 'group_id' => 4, 'group_name' => 'Product-details', 'short_name' => 'show page'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Product-details-import', 'group_id' => 4, 'group_name' => 'Product-details', 'short_name' => 'import'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Product-details-export', 'group_id' => 4, 'group_name' => 'Product-details', 'short_name' => 'export'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Product-details-adjust', 'group_id' => 4, 'group_name' => 'Product-details', 'short_name' => 'adjust'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Product-details-transfer', 'group_id' => 4, 'group_name' => 'Product-details', 'short_name' => 'transfer'
        ]);


        //Expense G-5
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Expense-showPage', 'group_id' => 5, 'group_name' => 'Expense', 'short_name' => 'show page'
        ]);

        //Reports G-6
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Reports-payments', 'group_id' => 6, 'group_name' => 'Reports', 'short_name' => 'payments'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Reports-claim-invoice', 'group_id' => 6, 'group_name' => 'Reports', 'short_name' => 'claim_invoice'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Reports-emirate-post', 'group_id' => 6, 'group_name' => 'Reports', 'short_name' => 'emirate_post'
        ]);


        //Chart-Of-Accounts G-7
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Chart-Of-Accounts-showPage', 'group_id' => 7, 'group_name' => 'Chart-Of-Accounts', 'short_name' => 'show page'
        ]);


        //Transaction G-8
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Transaction-Collect-Rider-Cash', 'group_id' => 8, 'group_name' => 'Transaction', 'short_name' => 'Collect Rider Cash'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Transaction-Withdrwal-Bank', 'group_id' => 8, 'group_name' => 'Transaction', 'short_name' => 'Withdrwal Bank'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Transaction-Withdrawal-From-Merchant', 'group_id' => 8, 'group_name' => 'Transaction', 'short_name' => 'Withdrawal From Merchant'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Transaction-Pay-To-Merchant', 'group_id' => 8, 'group_name' => 'Transaction', 'short_name' => 'Pay To Merchant'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Transaction-Show-Journals', 'group_id' => 8, 'group_name' => 'Transaction', 'short_name' => 'Show Journals'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Transaction-Journal-Voucher', 'group_id' => 8, 'group_name' => 'Transaction', 'short_name' => 'Journal Voucher'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Transaction-Recipt-Voucher', 'group_id' => 8, 'group_name' => 'Transaction', 'short_name' => 'Recipt Voucher'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Transaction-Payment-Voucher', 'group_id' => 8, 'group_name' => 'Transaction', 'short_name' => 'Payment Voucher'
        ]);

        //Branch G-9
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Branch-Show-Page', 'group_id' => 9, 'group_name' => 'Branch', 'short_name' => 'Show Page'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Branch-add', 'group_id' => 9, 'group_name' => 'Branch', 'short_name' => 'add'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Branch-show', 'group_id' => 9, 'group_name' => 'Branch', 'short_name' => 'show'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Branch-edit', 'group_id' => 9, 'group_name' => 'Branch', 'short_name' => 'edit'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Branch-delete', 'group_id' => 9, 'group_name' => 'Branch', 'short_name' => 'delete'
        ]);

        //City G-10
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-City-Show-Page', 'group_id' => 10, 'group_name' => 'City', 'short_name' => 'Show Page'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-City-add', 'group_id' => 10, 'group_name' => 'City', 'short_name' => 'add'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-City-show', 'group_id' => 10, 'group_name' => 'City', 'short_name' => 'show'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-City-edit', 'group_id' => 10, 'group_name' => 'City', 'short_name' => 'edit'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-City-delete', 'group_id' => 10, 'group_name' => 'City', 'short_name' => 'delete'
        ]);


        //General Setting G-11
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-General-Setting-Show-Page', 'group_id' => 11, 'group_name' => 'General Setting', 'short_name' => 'Show Page'
        ]);


        // admins G-12
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-admin-Show-Page', 'group_id' => 12, 'group_name' => 'Admins', 'short_name' => 'Show Page'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-admin-add',  'group_id' => 12, 'group_name' => 'Admins', 'short_name' => 'add'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' =>  'admin-admin-edit', 'group_id' => 12, 'group_name' => 'Admins', 'short_name' => 'edit'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-admin-delete', 'group_id' => 12, 'group_name' => 'Admins', 'short_name' => 'delete'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-admin-show', 'group_id' => 12, 'group_name' => 'Admins', 'short_name' => 'show'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-admin-Change-Status', 'group_id' => 12, 'group_name' => 'Admins', 'short_name' => 'Change Status'
        ]);


        //Customers G-13
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Customers-Show-Page', 'group_id' => 13, 'group_name' => 'Customers', 'short_name' => 'Show Page'
        ]);





        // Roles -> G-14
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-role-show-page', 'group_id' => 14, 'group_name' => 'Roles', 'short_name' => 'show page'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-role-add',  'group_id' => 14, 'group_name' => 'Roles', 'short_name' => 'add'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-role-edit', 'group_id' => 14, 'group_name' => 'Roles', 'short_name' => 'edit'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-role-delete', 'group_id' => 14, 'group_name' => 'Roles', 'short_name' => 'delete'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-role-show', 'group_id' => 14, 'group_name' => 'Roles', 'short_name' => 'show'
        ]);




        //  Rider -> G-15
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-rider-show-page', 'group_id' => 15, 'group_name' => 'Riders', 'short_name' => 'show page'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-rider-add',  'group_id' => 15, 'group_name' => 'Riders', 'short_name' => 'add'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' =>  'admin-rider-edit', 'group_id' => 15, 'group_name' => 'Riders', 'short_name' => 'edit'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-rider-delete', 'group_id' => 15, 'group_name' => 'Riders', 'short_name' => 'delete'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-rider-show', 'group_id' => 15, 'group_name' => 'Riders', 'short_name' => 'show'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-rider-change-status', 'group_id' => 15, 'group_name' => 'Riders', 'short_name' => 'change status'
        ]);

        //  Employees -> G-16
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Employees-show-page', 'group_id' => 16, 'group_name' => 'Employeess', 'short_name' => 'show page'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Employees-add',  'group_id' => 16, 'group_name' => 'Employeess', 'short_name' => 'add'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' =>  'admin-Employees-edit', 'group_id' => 16, 'group_name' => 'Employeess', 'short_name' => 'edit'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Employees-delete', 'group_id' => 16, 'group_name' => 'Employeess', 'short_name' => 'delete'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Employees-show', 'group_id' => 16, 'group_name' => 'Employeess', 'short_name' => 'show'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Employees-change-status', 'group_id' => 16, 'group_name' => 'Employeess', 'short_name' => 'change status'
        ]);

        //  Company -> G-17
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Company-show page', 'group_id' => 17, 'group_name' => 'Companys', 'short_name' => 'show page'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Company-add',  'group_id' => 17, 'group_name' => 'Companys', 'short_name' => 'add'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' =>  'admin-Company-edit', 'group_id' => 17, 'group_name' => 'Companys', 'short_name' => 'edit'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Company-delete', 'group_id' => 17, 'group_name' => 'Companys', 'short_name' => 'delete'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Company-show', 'group_id' => 17, 'group_name' => 'Companys', 'short_name' => 'show'
        ]);


        //  Shipment -> G-18
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Shipment-Report', 'group_id' => 18, 'group_name' => 'Shipments', 'short_name' => 'Report'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Shipment-add', 'group_id' => 18, 'group_name' => 'Shipments', 'short_name' => 'add'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Shipment-edit', 'group_id' => 18, 'group_name' => 'Shipments', 'short_name' => 'edit'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Shipment-delete', 'group_id' => 18, 'group_name' => 'Shipments', 'short_name' => 'delete'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Shipment-assign rider', 'group_id' => 18, 'group_name' => 'Shipments', 'short_name' => 'assign rider'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Shipment-print', 'group_id' => 18, 'group_name' => 'Shipments', 'short_name' => 'print'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Shipment-change-status', 'group_id' => 18, 'group_name' => 'Shipments', 'short_name' => 'change status'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Shipment-daily-report', 'group_id' => 18, 'group_name' => 'Shipments', 'short_name' => 'daily report'
        ]);
        Permission::create([
            'guard_name' => 'admin', 'name' => 'admin-Shipment-vendor-shipments', 'group_id' => 18, 'group_name' => 'Shipments', 'short_name' => 'vendor shipments'
        ]);





        /*************** Employee ************************/

        //WareHouse G-19
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-warehouse-show-products', 'group_id' => 19, 'group_name' => 'Branch WareHouse', 'short_name' => 'Show Products'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-warehouse-transfer-request', 'group_id' => 19, 'group_name' => 'Branch WareHouse', 'short_name' => 'Transfer Request'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-warehouse-delivered_quantity', 'group_id' => 19, 'group_name' => 'Branch WareHouse', 'short_name' => 'delivered_quantity'
        ]);


        //Employee G-20
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-Employee-show-page', 'group_id' => 20, 'group_name' => 'Branch Employees', 'short_name' => 'Show Page'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-Employee-add', 'group_id' => 20, 'group_name' => 'Branch Employees', 'short_name' => 'Add'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-Employee-show', 'group_id' => 20, 'group_name' => 'Branch Employees', 'short_name' => 'show'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-Employee-edit', 'group_id' => 20, 'group_name' => 'Branch Employees', 'short_name' => 'edit'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-Employee-change-status', 'group_id' => 20, 'group_name' => 'Branch Employees', 'short_name' => 'Change Status'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-Employee-delete', 'group_id' => 20, 'group_name' => 'Branch Employees', 'short_name' => 'delete'
        ]);


        //Rider G-21
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-rider-show-page', 'group_id' => 21, 'group_name' => 'Branch rider', 'short_name' => 'Show Page'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-rider-add', 'group_id' => 21, 'group_name' => 'Branch rider', 'short_name' => 'Add'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-rider-show', 'group_id' => 21, 'group_name' => 'Branch rider', 'short_name' => 'show'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-rider-edit', 'group_id' => 21, 'group_name' => 'Branch rider', 'short_name' => 'edit'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-rider-change-status', 'group_id' => 21, 'group_name' => 'Branch rider', 'short_name' => 'Change Status'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-rider-delete', 'group_id' => 21, 'group_name' => 'Branch rider', 'short_name' => 'delete'
        ]);


        //Role G-22
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-role-show-page', 'group_id' => 22, 'group_name' => 'Branch role', 'short_name' => 'Show Page'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-role-add', 'group_id' => 22, 'group_name' => 'Branch role', 'short_name' => 'Add'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-role-show', 'group_id' => 22, 'group_name' => 'Branch role', 'short_name' => 'show'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-role-edit', 'group_id' => 22, 'group_name' => 'Branch role', 'short_name' => 'edit'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-role-delete', 'group_id' => 22, 'group_name' => 'Branch role', 'short_name' => 'delete'
        ]);


        //Shipment G-23
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-Shipment-Report', 'group_id' => 23, 'group_name' => 'Branch Shipments', 'short_name' => 'Report'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-Shipment-add', 'group_id' => 23, 'group_name' => 'Branch Shipments', 'short_name' => 'add'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-Shipment-edit', 'group_id' => 23, 'group_name' => 'Branch Shipments', 'short_name' => 'edit'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-Shipment-delete', 'group_id' => 23, 'group_name' => 'Branch Shipments', 'short_name' => 'delete'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-Shipment-assign rider', 'group_id' => 23, 'group_name' => 'Branch Shipments', 'short_name' => 'assign rider'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-Shipment-print', 'group_id' => 23, 'group_name' => 'Branch Shipments', 'short_name' => 'print'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-Shipment-change-status', 'group_id' => 23, 'group_name' => 'Branch Shipments', 'short_name' => 'change status'
        ]);
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-Shipment-daily-report', 'group_id' => 23, 'group_name' => 'Branch Shipments', 'short_name' => 'daily report'
        ]);

        //Expenses G-24
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-Expense-show-page', 'group_id' => 24, 'group_name' => 'Branch Expenses', 'short_name' => 'Show Page'
        ]);

        //transiction G-25
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-transiction-collect-cash', 'group_id' => 25, 'group_name' => 'Branch Transiction', 'short_name' => 'collect cash'
        ]);

        //Report G-26
        Permission::create([
            'guard_name' => 'employee', 'name' => 'employee-report-paymetns', 'group_id' => 26, 'group_name' => 'Branch Report', 'short_name' => 'Paymetn Report'
        ]);
    }
}
