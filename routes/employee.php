<?php

use App\Http\Controllers\Employee\Accounting\AccountTreeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\AuthController;
use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Employee\Expenses\ExpensesController;
use App\Http\Controllers\Employee\Product\ProductController;
use App\Http\Controllers\Employee\ProductDetails\ProductDetailsController;
use App\Http\Controllers\Employee\Profile\EmployeeProfileController;
use App\Http\Controllers\Employee\ReportController;
use App\Http\Controllers\Employee\Shipment\ShipmentController;
use App\Http\Controllers\Employee\TransactionController;
use App\Http\Controllers\Employee\Transfer\TransferController;
use App\Http\Controllers\Employee\TransferProduct\TransferProductController;
use App\Http\Controllers\Employee\UserManagment\EmployeeController;
use App\Http\Controllers\Employee\Warehouse\WarehouseController;
use App\Http\Controllers\Employee\WarehouseReport\WarehouseReportController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Employee\UserManagment\RoleController;
use App\Http\Controllers\Employee\UserManagment\UserRiderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('employee')->name('employee.')->group(function () {

    Route::get('login', [AuthController::class, 'Login'])->name('login.form'); // روت تسجيل الدخول للادارة
    Route::post('/login/check', [AuthController::class, 'LoginRequest'])->name('check.login'); // روت التحقق من المستخدم و صلاحية
    Route::get('forget', [AuthController::class, 'Forget'])->name('forget_password');
    Route::post('forget/password', [AuthController::class, 'store'])->name('reset_password_link');


    Route::middleware(['employee'])->group(function () {  //admin auth area



        Route::get('/logout', [AuthController::class, 'Logout'])->name('logout'); // Logout Route
        // Start Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('index'); // روت تسجيل الدخول للادارة
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('index'); // روت تسجيل الدخول للادارة
        // End Dashboard


        //start user management
        //بداية admin profile
        Route::controller(EmployeeProfileController::class)->group(function () {
            Route::get('/users/employee/profile', 'index')->name('employee_profile_index');
            Route::post('/employee/update_password', 'update_password')->name('employee_update_password');
        }); //نهاية  admin profile



        //بداية rider users
        Route::controller(UserRiderController::class)->group(function () {
            Route::get('/users/rider/list', 'index')->name('users_rider_index');
            Route::get('/users/rider/add', 'create')->name('users_rider_create');
            Route::get('/users/rider/edit/{id}', 'edit')->name('users_rider_edit');
            Route::post('/users/rider/update', 'updateRider')->name('users_rider_update');
            Route::post('/users/rider/store', 'store')->name('users_rider_store');
            Route::delete('/users/rider/destroy/{id}', 'destroy')->name('users_rider_destroy');
            Route::delete('/users/rider/delete', 'delete_rider')->name('users_rider_delete');
            Route::get('/users/rider/{id}', 'show')->name('users_rider_show');
            Route::post('/users/rider/search', 'search')->name('users_rider_search');
            Route::post('/users/rider/update_password', 'update_password')->name('users_rider_update_password');
            Route::post('/users/rider/update-status/{id}', 'update_status')->name('users_rider_update_status');
            // }); //نهاية  rider users




            //بداية employee users
            Route::controller(EmployeeController::class)->group(function () {
                Route::get('/users/employee/employee/list', 'index')->name('users_employee_index');
                Route::get('/users/employee/employee/add', 'create')->name('users_employee_create');
                Route::get('/users/employee/employee/edit/{id}', 'edit')->name('users_employee_edit');
                Route::post('/users/employee/employee/update', 'updateEmployee')->name('users_employee_update');
                Route::post('/users/employee/employee/store', 'store')->name('users_employee_store');
                Route::delete('/users/employee/employee/destroy/{id}', 'destroy')->name('users_employee_destroy');
                Route::delete('/users/employee/employee/delete', 'delete_employee')->name('users_employee_delete');
                Route::get('/users/employee/employee/{id}', 'show')->name('users_employee_show');
                Route::post('/users/employee/employee/search', 'search')->name('users_employee_search');
                Route::post('/users/employee/employee/update_password', 'update_password')->name('users_employee_update_password');
                Route::post('/users/employee/employee/update-status/{id}', 'update_status')->name('users_employee_update_status');
            }); //نهاية  employee users
            //end user management





            // start Roles
            Route::controller(RoleController::class)->group(function () {
                Route::get('/users/employee/roles/list', 'index')->name('roles_employee_index');
                Route::get('/users/employee/roles/show', 'show')->name('roles_employee_show');
                Route::post('/users/employee/roles/store', 'store')->name('roles_employee_store');
                Route::post('/users/employee/roles/update', 'update')->name('roles_employee_update');
                Route::delete('/users/employee/roles/delete/{id}', 'destroy')->name('roles_employee_destroy');
            });
            // End Roles


            //بداية  expenses
            Route::controller(ExpensesController::class)->group(function () {
                Route::get('/expenses', 'index')->name('expenses_index');
                Route::get('/expenses/add', 'create')->name('expenses_create');
                Route::get('/expenses/edit/{id}', 'edit')->name('expenses_edit');
                Route::post('/expenses/update', 'updateshopify')->name('expenses_update');
                Route::post('/expenses/store', 'store')->name('expenses_store');
                Route::post('/expenses/config', 'saveShopifyConfig')->name('expenses_config');
                Route::delete('/expenses/destroy', 'destroy')->name('expenses_destroy');
                Route::get('/expenses/{id}', 'show')->name('expenses_show');
                Route::post('/expenses/update-status/{id}', 'updateStatus')->name('expenses_status_update');
            });

            //بداية  warehouse
            Route::controller(WarehouseController::class)->group(function () {
                Route::get('/warehouse', 'index')->name('warehouse_index');
                Route::get('/warehouse/add', 'create')->name('warehouse_create');
                Route::get('/warehouse/edit/{id}', 'edit')->name('warehouse_edit');
                Route::put('/warehouse/update/{id}', 'update')->name('warehouse_update');
                Route::post('/warehouse/store', 'store')->name('warehouse_store');
                Route::post('/warehouse/config', 'savewarehouseConfig')->name('warehouse_config');
                Route::delete('/warehouse/destroy/{id}', 'destroy')->name('warehouse_destroy');
                Route::post('/warehouse/{id}', [WarehouseController::class, 'delete_warehouse'])->name('warehouse_delete');
                Route::get('/warehouse/{id}', 'show')->name('warehouse_show');
                Route::post('/warehouse/update-status/{id}', 'updateStatus')->name('warehouse_status_update');
            });
            //نهاية warehouse
            //بداية  warehouse report
            Route::controller(WarehouseReportController::class)->group(function () {
                Route::get('/warehouse_report', 'index')->name('warehouse_report_index');
                Route::get('/warehouse_report/add', 'create')->name('warehouse_report_create');
                Route::get('/warehouse_report/edit/{id}', 'edit')->name('warehouse_report_edit');
                Route::put('/warehouse_report/update/{id}', 'update')->name('warehouse_report_update');
                Route::post('/warehouse_report/store', 'store')->name('warehouse_report_store');
                Route::post('/warehouse_report/config', 'savewarehouseConfig')->name('warehouse_report_config');
                Route::delete('/warehouse_report/destroy/{id}', 'destroy')->name('warehouse_report_destroy');
                Route::get('/warehouse_report/{id}', 'show')->name('warehouse_report_show');
                Route::post('/warehouse_report/update-status/{id}', 'updateStatus')->name('warehouse_report_status_update');
            });
            //نهاية warehouse report

            //بداية  products
            Route::controller(ProductController::class)->group(function () {
                Route::get('/products', 'index')->name('products_index');
                Route::get('/products/add', 'create')->name('products_create');
                Route::get('/products/edit/{id}', 'edit')->name('products_edit');
                Route::post('/products/update', 'updateproducts')->name('products_update');
                Route::post('/products/store', 'store')->name('products_store');
                Route::post('/products/config', 'saveproductsConfig')->name('products_config');
                Route::delete('/products/destroy/{id}', 'destroy')->name('products_destroy');
                Route::post('/products/{id}', [ProductController::class, 'delete_products'])->name('products_delete');
                Route::get('/products/{id}', 'show')->name('products_show');
                Route::post('/products/update-status/{id}', 'updateStatus')->name('warehouse_status_update');
                Route::post('/products/import-export', 'productImportExport')->name('product_import_export');
            });
            //نهاية products

            //بداية  product-details
            Route::controller(ProductDetailsController::class)->group(function () {
                Route::get('/product-details', 'index')->name('product_details_index');
                Route::get('/product-details/add', 'create')->name('product_details_create');
                Route::get('/product-details/edit/{id}', 'edit')->name('product_details_edit');
                Route::post('/product-details/update', 'updateproduct-details')->name('product_details_update');
                Route::post('/product-details/store', 'store')->name('product_details_store');
                Route::post('/product-details/deliver', 'deliver')->name('product_details_deliver');
                Route::post('/product-details/config', 'saveproduct-detailsConfig')->name('product_details_config');

                Route::get('/product-details/{id}', 'show')->name('product_details_show');
                Route::post('/product-details/update-status/{id}', 'updateStatus')->name('warehouse_status_update');
                Route::post('/product-details/import-export', 'productImportExport')->name('product_import_export');
                Route::delete('/product-details/destroy/{id}', 'destroy')->name('product_details_destroy');
            });
            //نهاية product-details

            //بداية  transfer
            Route::controller(TransferController::class)->group(function () {
                Route::get('/transfer', 'index')->name('transfer_index');
                Route::get('/transfer/add', 'create')->name('transfer_create');
                Route::get('/transfer/edit/{id}', 'edit')->name('transfer_edit');
                Route::post('/transfer/update', 'updatetransfer')->name('transfer_update');
                Route::post('/transfer/store', 'store')->name('transfer_store');
                Route::post('/transfer/config', 'savetransferConfig')->name('transfer_config');
                Route::delete('/transfer/destroy/{id}', 'destroy')->name('transfer_destroy');
                Route::post('/transfer/{id}', [TransferController::class, 'delete_transfer'])->name('transfer_delete');
                Route::get('/transfer/{id}', 'show')->name('transfer_show');
                Route::post('/transfer/update-status/{id}', 'updateStatus')->name('warehouse_status_update');
                Route::get('/transfer/vendors/products', 'getVendorProducts')->name('vendors_company_get_products');
            });
            //نهاية transfer

            //بداية  transfer-products
            Route::controller(TransferProductController::class)->group(function () {
                Route::get('/transfer-products', 'index')->name('transfer_product_index');
                Route::get('/transfer-products/add', 'create')->name('transfer_product_create');
                Route::get('/transfer-products/edit/{id}', 'edit')->name('transfer_product_edit');
                Route::put('/transfer-products/update/{id}', 'update')->name('transfer_product_update');
                Route::post('/transfer-products/store', 'store')->name('transfer_product_store');
                Route::post('/transfer-products/config', 'savetransferConfig')->name('transfer_product_config');
                Route::delete('/transfer-products/destroy/{id}', 'destroy')->name('transfer_product_destroy');
                Route::get('/transfer-products/{id}', 'show')->name('transfer_product_show');
            });
            //نهاية transfer-products


            // shipments

            Route::controller(ShipmentController::class)->group(function () {
                Route::get('/shipments/all', 'index')->name('shipments_index');
                Route::get('/shipments/create', 'create')->name('shipments_create');
                Route::post('/shipments/store', 'store')->name('shipments_store');
                Route::get('/shipments/shipment_actions/{id}', 'shipment_actions')->name('shipment_actions');
                Route::get('/shipments/edit/{id}', 'edit')->name('shipments_edit');
                Route::post('/shipments/update/', 'update')->name('shipments_update');
                Route::post('/shipments/assign_rider/', 'assignRider')->name('shipment_assign_rider');
                Route::post('/shipments/change_status/', 'changeStatus')->name('shipments_change_status');
                Route::get('/shipments/delete/', 'delete')->name('shipments_delete');



                Route::get('shipment/print_invoice/{id}', 'printInvoice')->name('shipment_print_invoice');
                Route::get('shipment/print_sticker/{id}', 'printSticker')->name('shipment_print_sticker');


                Route::get('shipment/vendor_stickers', 'multi_stickers')->name('shipment_vendor_stickers');
                Route::post('shipment/print_vendor_stickers', 'printVendorStickers')->name('shipment_print_vendor_stickers');



                Route::get('shipment/shipment_company_has_stock', 'shipmentCompanyHasStock')->name('shipment_company_has_stock');
                Route::get('shipment/shipment_prodcut_details', 'shipmentProdcutDetails')->name('shipment_prodcut_details');
                Route::get('shipment/shipment_get_cities', 'shipmentGetCities')->name('shipment_get_cities');
                Route::get('shipment/return_product_to_stock', 'returnProductToStock')->name('return_product_to_stock');
                Route::get('shipment/get_shipment_products', 'getShipmentProducts')->name('getShipmentProducts');
                Route::get('shipment/getShipmentClient', 'getShipmentClient')->name('getShipmentClient');


                Route::get('shipment/daily_shipment_rider', 'dailyShipmentRider')->name('shipments_daily_rider');
                Route::get('shipment/dailyReport', 'dailyReport')->name('shipments_daily_report');

                Route::get('shipment/assign_to_rider', 'assignToRider')->name('shipments_assign_to_rider');
                Route::post('shipment/assign-shipmets-rider', 'assignShipments')->name('assignShipments');

                Route::get('shipment/vendor_invoices', 'multi_invoices')->name('shipment_vendor_invoices');
                Route::post('shipment/print_vendor_invoices', 'printVendorInvoices')->name('shipment_print_vendor_invoices');


                Route::post('shipment/search','search')->name('shipment.search');

                Route::get('/downloadfile','downloadfile')->name('shipment.downloadfile');
                Route::post('shipment/import', 'import')->name('shipment.import');

            });
            //end shipments

            //reports
            Route::controller(ReportController::class)->group(function () {
                Route::get('shipment/report', 'shipmentsReport')->name('shipments_report');
                Route::get('/payments/report', 'paymentsReport')->name('reports_payments');
            });


            Route::controller(TransactionController::class)->group(function () {
                Route::get('collect-cash/rider', 'collectRiderCash')->name('transactions_get_collect_rider_cash');
                Route::post('collect-cash-rider', 'collectCashRider')->name('transactions_collect_rider_cash');

                Route::get('collect-cash/merchant', 'WithdrawalMerchant')->name('transactions_get_Withdrawal_from_the_merchant');
                Route::post('collect-merchant', 'MerchantWithdrawal')->name('transactions_Withdrawal_from_the_merchant');

                Route::get('collect-cash/bank', 'WithdrawalBank')->name('transactions_get_Withdrawal_from_bank');
                Route::post('collect-bank', 'BankWithdrawal')->name('transactions_Withdrawal_from_bank');

                Route::get('collect-cash/pay_to_merchant', 'getPayToTheMerchant')->name('transactions_get_pay_to_the_merchant');
                Route::post('pay_to_merchant', 'payToTheMerchant')->name('transactions_pay_to_the_merchant');
            });
        }); //end admin auth area
    });
});
require __DIR__ . '/auth.php';
