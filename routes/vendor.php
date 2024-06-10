<?php

use App\Http\Controllers\Employee\Accounting\AccountTreeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\AuthController;
use App\Http\Controllers\Vendor\DashboardController;
use App\Http\Controllers\Vendor\Expenses\ExpensesController;
use App\Http\Controllers\Vendor\Product\ProductController;
use App\Http\Controllers\Vendor\ProductDetails\ProductDetailsController;
use App\Http\Controllers\Vendor\Profile\EmployeeProfileController;
use App\Http\Controllers\Vendor\ReportController;
use App\Http\Controllers\Vendor\Shipment\ShipmentController;
use App\Http\Controllers\Vendor\TransactionController;
use App\Http\Controllers\Vendor\Transfer\TransferController;
use App\Http\Controllers\Vendor\TransferProduct\TransferProductController;
use App\Http\Controllers\Vendor\UserManagment\EmployeeController;
use App\Http\Controllers\Vendor\Warehouse\WarehouseController;
use App\Http\Controllers\Vendor\WarehouseReport\WarehouseReportController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Employee\UserManagment\RoleController;
use App\Http\Controllers\Employee\UserManagment\UserRiderController;
use App\Http\Controllers\Vendor\Profile\VendorProfileController;

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

Route::prefix('vendor')->name('vendor.')->group(function () {

    Route::get('login', [AuthController::class, 'Login'])->name('login.form'); // روت تسجيل الدخول للادارة
    Route::post('/login/check', [AuthController::class, 'LoginRequest'])->name('check.login'); // روت التحقق من المستخدم و صلاحية
    Route::get('forget', [AuthController::class, 'Forget'])->name('forget_password');
    Route::post('forget/password', [AuthController::class, 'store'])->name('reset_password_link');


    Route::middleware(['vendor'])->group(function () {  //admin auth area

        Route::get('/logout', [AuthController::class, 'Logout'])->name('logout'); // Logout Route
        // Start Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('index'); // روت تسجيل الدخول للادارة
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('index'); // روت تسجيل الدخول للادارة
        // End Dashboard


        //start user management
        //بداية admin profile
        Route::controller(VendorProfileController::class)->group(function () {
            Route::get('/users/vendor/profile', 'index')->name('vendor_profile_index');
            Route::post('/vendor/update_password', 'update_password')->name('vendor_update_password');
        }); //نهاية  admin profile



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



            Route::post('shipment/search', 'search')->name('shipment.search');

            // import excel
            Route::get('/downloadfile','downloadfile')->name('shipment.downloadfile');
            Route::post('shipment/import', 'import')->name('shipment.import');
        });
        //end shipments

        //reports
        Route::controller(ReportController::class)->group(function () {
            Route::get('shipment/report', 'shipmentsReport')->name('shipments_report');
            Route::get('/payments/report', 'paymentsReport')->name('reports_payments');
        });
    }); //end admin auth area
});
require __DIR__ . '/auth.php';
