<?php

use App\Http\Controllers\Admin\Accounting\AccountTreeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\City\CityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Branch\BranchController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\UserManagment\RoleController;
use App\Http\Controllers\Admin\FinanceYear\FinanceYearController;
use App\Http\Controllers\Admin\UserManagment\UserAdminController;
use App\Http\Controllers\Admin\MailSettings\MailSettingsController;
use App\Http\Controllers\Admin\Accounting\ChartOfAccountsController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CompanyVendors\CompanyController;
use App\Http\Controllers\Admin\Expenses\ExpensesController;
use App\Http\Controllers\Admin\FirebaseSettings\FirebaseSettingsController;
use App\Http\Controllers\Admin\GoogleMapSettings\GoogleMapSettingsController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\ProductDetails\ProductDetailsController;
use App\Http\Controllers\Admin\Profile\AdminProfileController;
use App\Http\Controllers\Admin\RecivedController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RiderLocationController;
use App\Http\Controllers\Admin\Shipment\ShipmentController;
use App\Http\Controllers\Admin\Shopify\ShopifyController;
use App\Http\Controllers\Admin\Shopify\ShopifyOrdersController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\Transfer\TransferController;
use App\Http\Controllers\Admin\TransferProduct\TransferProductController;
use App\Http\Controllers\Admin\UserManagment\EmployeeController;
use App\Http\Controllers\Admin\UserManagment\UserCustomerController;
use App\Http\Controllers\Admin\UserManagment\UserRiderController;
use App\Http\Controllers\Admin\Warehouse\WarehouseController;
use App\Http\Controllers\Admin\WarehouseReport\WarehouseReportController;
use App\Http\Controllers\Admin\WhatsappSmsSettings\WhatsappSmsSettingsController;
use App\Http\Controllers\Controller;

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

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [AuthController::class, 'Login'])->name('login.form'); // روت تسجيل الدخول للادارة
    Route::post('/login/check', [AuthController::class, 'LoginRequest'])->name('check.login'); // روت التحقق من المستخدم و صلاحية
    Route::get('forget', [AuthController::class, 'Forget'])->name('forget_password');
    Route::post('forget/password', [AuthController::class, 'store'])->name('reset_password_link');


    Route::middleware(['admin'])->group(function () {  //admin auth area



        Route::get('/logout', [AuthController::class, 'Logout'])->name('logout'); // Logout Route
        // Start Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('index'); // روت تسجيل الدخول للادارة
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('index'); // روت تسجيل الدخول للادارة
        // End Dashboard


        //start user management
        //بداية admin profile
        Route::controller(AdminProfileController::class)->group(function () {
            Route::get('/users/admin/profile', 'index')->name('admin_profile_index');
            // Route::get('/users/admin/add', 'create')->name('users_admin_create');
            // Route::get('/users/admin/edit/{id}', 'edit')->name('users_admin_edit');
            // Route::post('/users/admin/update', 'updateAdmin')->name('users_admin_update');
            // Route::post('/users/admin/store', 'store')->name('users_admin_store');
            // Route::delete('/users/admin/destroy/{id}', 'destroy')->name('users_admin_destroy');
            // Route::delete('/users/admin/delete', 'delete_admin')->name('users_admin_delete');
            // Route::get('/users/admin/{id}', 'show')->name('users_admin_show');
            // Route::post('/users/admin/search', 'search')->name('users_admin_search');
            Route::post('/admin/update_password', 'update_password')->name('admin_update_password');
        }); //نهاية  admin profile

        //بداية admin users
        Route::controller(UserAdminController::class)->group(function () {
            Route::get('/users/admin/list', 'index')->name('users_admin_index');
            Route::get('/users/admin/add', 'create')->name('users_admin_create');
            Route::get('/users/admin/edit/{id}', 'edit')->name('users_admin_edit');
            Route::post('/users/admin/update', 'updateAdmin')->name('users_admin_update');
            Route::post('/users/admin/store', 'store')->name('users_admin_store');
            Route::delete('/users/admin/destroy/{id}', 'destroy')->name('users_admin_destroy');
            Route::delete('/users/admin/delete', 'delete_admin')->name('users_admin_delete');
            Route::get('/users/admin/{id}', 'show')->name('users_admin_show');
            Route::post('/users/admin/search', 'search')->name('users_admin_search');
            Route::post('/users/admin/update_password', 'update_password')->name('users_admin_update_password');
            Route::post('/users/admin/update-status/{id}', 'update_status')->name('users_admin_update_status');
        }); //نهاية  admin users

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
        }); //نهاية  rider users


        //بداية customer users
        Route::controller(UserCustomerController::class)->group(function () {
            Route::get('/users/admin/customer/list', 'index')->name('users_customer_index');
            Route::get('/users/admin/customer/add', 'create')->name('users_customer_create');
            Route::get('/users/admin/customer/edit/{id}', 'edit')->name('users_customer_edit');
            Route::post('/users/admin/customer/update', 'updateCustomer')->name('users_customer_update');
            Route::post('/users/admin/customer/store', 'store')->name('users_customer_store');
            Route::delete('/users/admin/customer/destroy/{id}', 'destroy')->name('users_customer_destroy');
            Route::delete('/users/admin/customer/delete', 'delete_customer')->name('users_customer_delete');
            Route::get('/users/admin/customer/{id}', 'show')->name('users_customer_show');
            Route::post('/users/admin/customer/search', 'search')->name('users_customer_search');
            Route::post('/users/admin/customer/update_password', 'update_password')->name('users_customer_update_password');
            Route::post('/users/admin/customer/update-status/{id}', 'update_status')->name('users_customer_update_status');
        }); //نهاية  customer users

        //بداية employee users
        Route::controller(EmployeeController::class)->group(function () {
            Route::get('/users/admin/employee/list', 'index')->name('users_employee_index');
            Route::get('/users/admin/employee/add', 'create')->name('users_employee_create');
            Route::get('/users/admin/employee/edit/{id}', 'edit')->name('users_employee_edit');
            Route::post('/users/admin/employee/update', 'updateEmployee')->name('users_employee_update');
            Route::post('/users/admin/employee/store', 'store')->name('users_employee_store');
            Route::delete('/users/admin/employee/destroy/{id}', 'destroy')->name('users_employee_destroy');
            Route::delete('/users/admin/employee/delete', 'delete_employee')->name('users_employee_delete');
            Route::get('/users/admin/employee/{id}', 'show')->name('users_employee_show');
            Route::post('/users/admin/employee/search', 'search')->name('users_employee_search');
            Route::post('/users/admin/employee/update_password', 'update_password')->name('users_employee_update_password');
            Route::post('/users/admin/employee/update-status/{id}', 'update_status')->name('users_employee_update_status');
        }); //نهاية  employee users
        //end user management

        // start vendor companies routes
        Route::controller(CompanyController::class)->group(function () {
            Route::get('/vendors/company/list', 'index')->name('vendors_company_index');
            Route::post('/vendors/company/search', 'search')->name('vendors_company_search');
            Route::get('/vendors/company/create', 'create')->name('vendors_company_create');
            Route::post('/vendors/company/store', 'store')->name('vendors_company_store');
            Route::get('/emirate/city/', 'getCieiesByEmirate')->name('vendors_company_get_cities');
            Route::get('/vendors/company/edit/{id}', 'edit')->name('vendors_company_edit');
            Route::post('/vendors/company/update', 'update')->name('vendors_company_update');
            Route::get('/vendors/company/delete/{id}', 'destroy')->name('vendors_company_delete');
            Route::post('/vendors/ompany/update-status/{id}', 'update_status')->name('vendors_company_update_status');
        });


        // end vendor companies routes



        // start Roles
        Route::controller(RoleController::class)->group(function () {
            Route::get('/users/admin/roles/list', 'index')->name('roles_admin_index');
            Route::get('/users/admin/roles/show', 'show')->name('roles_admin_show');
            Route::post('/users/admin/roles/store', 'store')->name('roles_admin_store');
            Route::post('/users/admin/roles/update', 'update')->name('roles_admin_update');
            Route::delete('/users/admin/roles/delete/{id}', 'destroy')->name('roles_admin_destroy');
        });
        // End Roles

        // Start Chart  of accounts
        Route::get('/account/dashboard', [ChartOfAccountsController::class, 'Dashboard'])->name('account.dashboard');

        Route::controller(AccountTreeController::class)->group(function () {

            Route::get('/account', 'index')->name('account.index');
            Route::get('/account/get_parent', 'getParent')->name('account.get_parent');
            Route::post('/account/store', 'store')->name('account.store');
            Route::get('/account/edit',  'edit')->name('account.edit');

            Route::get('/account/transiction/journals', 'journals')->name('account.journals');

            Route::get('/account/transiction/journal_voucher', 'journalVoucher')->name('account.journal_voucher');
            Route::post('/account/transiction/journal_voucher/store', 'storeJournalVoucher')->name('account.store_journal_voucher');

            Route::get('/account/transiction/recipt_voucher', 'reciptVoucher')->name('account.recipt_voucher');
            Route::post('/account/transiction/recipt_voucher/store', 'storeReciptVoucher')->name('account.store_recipt_voucher');
            Route::get('/account/transiction/print_recipt_voucher/{number}', 'printReciptVoucher')->name('account.print_recipt_voucher');

            Route::get('/account/transiction/payment_voucher', 'paymentVoucher')->name('account.payment_voucher');
            Route::post('/account/transiction/payment_voucher/store', 'storepaymentVoucher')->name('account.store_payment_voucher');
            Route::get('/account/transiction/print_payment_voucher/{number}', 'printPaymentVoucher')->name('account.print_payment_voucher');

            Route::post('/account/transiction/bulk', 'bulk_payment')->name('account.bulk_payment');
        });

        // Route::get('/account/chart/create', [ChartOfAccountsController::class, 'create'])->name('account.create');
        // Route::post('/account/chart/store_level_I', [ChartOfAccountsController::class, 'storeLevelI'])->name('account.store_level_I');
        // Route::post('/account/chart/store_level_II', [ChartOfAccountsController::class, 'storeLevelII'])->name('account.store_level_II');
        // Route::post('/account/chart/update_level_I', [ChartOfAccountsController::class, 'updateLevelI'])->name('account.update_level_I');
        // Route::post('/account/chart/update_level_II', [ChartOfAccountsController::class, 'updateLevelII'])->name('account.update_level_II');
        // Route::delete('/account/chart/delete_level_I/{id}', [ChartOfAccountsController::class, 'destroylevelI'])->name('account.destroy_level_I');
        // Route::delete('/account/chart/delete_level_II/{id}', [ChartOfAccountsController::class, 'destroylevelII'])->name('account.destroy_level_II');
        // End Chart  of accounts


        //بداية اعدادات الضبط العام
        Route::controller(GeneralSettingController::class)->prefix('setting')->group(function () {

            Route::get('', 'setting')->name('setting');
            Route::get('/software/setting', 'softwareSetting')->name('software_setting');
            Route::post('/software/update', 'updateSettings')->name('update_settings');
        });


        //بداية الفروع
        Route::controller(BranchController::class)->group(function () {
            Route::get('/branch/list', 'index')->name('branch_index');
            Route::get('/branch/add', 'create')->name('branch_create');
            Route::get('/branch/edit/{id}', 'edit')->name('branch_edit');
            Route::post('/branch/update', 'updateBranch')->name('branch_update');
            Route::post('/branch/store', 'store')->name('branch_store');
            Route::delete('/branch/destroy', 'destroy')->name('branch_destroy');
            Route::post('/branch/{id}', [BranchController::class, 'delete_branch'])->name('branch_delete');
            Route::get('/branch/{id}', 'show')->name('branch_show');
            Route::post('/branch/update-status/{id}', 'updateStatus')->name('branch_status_update');
        }); //نهاية  الفروع

        //بداية المناطق
        Route::controller(CityController::class)->group(function () {
            Route::get('/city/index', 'index')->name('city_index');
            Route::get('/city/add', 'create')->name('city_create');
            Route::post('/city/store', 'store')->name('city_store');
            Route::get('/city/edit/{id}', 'edit')->name('city_edit');
            Route::post('/city/update/{id}', 'update')->name('city_update');
            Route::delete('/city/destroy', 'destroy')->name('city_destroy');
            Route::get('/city/{id}', 'show')->name('city_show');
            Route::post('/city/{id}', [CityController::class, 'delete_city'])->name('city_delete');
        }); //نهاية  المناطق

        //بداية السيارات
        Route::controller(CarController::class)->group(function () {
            Route::get('/cars/index', 'index')->name('cars_index');
            Route::get('/car/add', 'create')->name('cars_create');
            Route::get('/car/edit/{id}', 'edit')->name('cars_edit');
            Route::post('/car/update/{id}', 'update')->name('cars_update');
            Route::post('/car/store', 'store')->name('cars_store');
            Route::delete('/car/destroy', 'destroy')->name('cars_destroy');
            Route::get('/car/{id}', 'show')->name('cars_show');
            Route::post('/car/{id}', [CarController::class, 'delete_car'])->name('cars_delete');
        }); //نهاية  السيارات

        //بداية السنوات المالية
        Route::controller(FinanceYearController::class)->group(function () {
            Route::get('/finance-year/index', 'index')->name('finance_year_index');
            Route::get('/finance-year/add', 'create')->name('finance_year_create');
            Route::get('/finance-year/edit/{id}', 'edit')->name('finance_year_edit');
            Route::post('/finance-year/update/{id}', 'update')->name('finance_year_update');
            Route::post('/finance-year/store', 'store')->name('finance_year_store');
            Route::delete('/finance-year/destroy', 'destroy')->name('finance_year_destroy');
            Route::get('/finance-year/{id}', 'show')->name('finance_year_show');
            Route::post('/finance-year/update-status/{id}', 'updateStatus')->name('finance_status_update');
            Route::post('/finance-year/{id}', [FinanceYearController::class, 'delete_finance_year'])->name('finance_year_delete');
        });
        //نهاية السنوات المالية

        //بداية البريد
        Route::controller(MailSettingsController::class)->group(function () {
            Route::get('/mail/config', 'mail_config')->name('mail_config');
            Route::get('/mail/test', 'mail_test')->name('mail_test');
            Route::post('/mail/config', 'updateMailSetting')->name('update_mail_setting');
            //Route::post('/mail/push', 'updatePushNotification')->name('update_push_notification');
            //Route::post('/mail/config', 'updateConfig')->name('update_config');
            //Route::post('/mail/{id}', [FinanceYearController::class, 'delete_mail'])->name('mail_delete');

        });
        //نهاية البريد

        //بداية الرسائل و الواتساب
        Route::controller(WhatsappSmsSettingsController::class)->group(function () {
            Route::get('/whatsapp-sms/whatsapp', 'whatsapp_settings')->name('whatsapp_settings');
            //Route::get('/whatsapp-sms\/sms', 'sms_settings')->name('sms_settings');
            Route::post('/whatsapp-sms/update', 'updateWhatsappConfig')->name('update_whatsapp_config');
            //Route::post('/firebase/config', 'updateConfig')->name('update_config');

        });
        //نهاية الرسائل و الواتساب

        //بداية google map
        Route::controller(GoogleMapSettingsController::class)->group(function () {
            Route::get('/map', 'map_settings')->name('map_settings');
            Route::post('/map/update', 'updateMapConfig')->name('update_map_config');
        });
        //نهاية google map

        //بداية firebase
        Route::controller(FirebaseSettingsController::class)->group(function () {

            Route::get('/firebase/push', 'push_notification')->name('push_notification');
            Route::get('/firebase/config', 'config_notification')->name('config_notification');
            Route::post('/firebase/push', 'updatePushNotification')->name('update_push_notification');
            Route::post('/firebase/config', 'updateConfig')->name('update_config');
        });
        //نهاية firebase


        //بداية  shopify
        Route::controller(ShopifyController::class)->group(function () {
            Route::get('/shopify', 'index')->name('shopify_settings');
            Route::get('/shopify/add', 'create')->name('shopify_create');
            Route::get('/shopify/edit/{id}', 'edit')->name('shopify_edit');
            Route::post('/shopify/update', 'updateshopify')->name('shopify_update');
            Route::post('/shopify/store', 'store')->name('shopify_store');
            Route::post('/shopify/config', 'saveShopifyConfig')->name('shopify_config');
            Route::delete('/shopify/destroy', 'destroy')->name('shopify_destroy');
            Route::post('/shopify/{id}', [shopifyController::class, 'delete_shopify'])->name('shopify_delete');
            Route::get('/shopify/{id}', 'show')->name('shopify_show');
            Route::post('/shopify/update-status/{id}', 'updateStatus')->name('shopify_status_update');
        });
        //نهاية shopify
        //بداية  expenses
        Route::controller(ExpensesController::class)->group(function () {
            Route::get('/expenses', 'index')->name('expenses_index');
            Route::get('/expenses/add', 'create')->name('expenses_create');
            Route::get('/expenses/edit/{id}', 'edit')->name('expenses_edit');
            Route::post('/expenses/update', 'update')->name('expenses_update');
            Route::post('/expenses/store', 'store')->name('expenses_store');
            Route::post('/expenses/config', 'saveShopifyConfig')->name('expenses_config');
            Route::delete('/expenses/destroy', 'destroy')->name('expenses_destroy');
            //Route::post('/expenses/{id}', [ExpensesController::class, 'delete_shopify'])->name('expenses_delete');
            Route::get('/expenses/{id}', 'show')->name('expenses_show');
            Route::post('/expenses/update-status/{id}', 'updateStatus')->name('expenses_status_update');
        });
        //نهاية expenses
        Route::controller(ShopifyOrdersController::class)->group(function () {
            Route::get('/shopify-orders', 'index')->name('shopify_orders_settings');
            Route::get('/shopify-orders/add', 'create')->name('shopify_orders_create');
            Route::get('/shopify-orders/edit/{id}', 'edit')->name('shopify_orders_edit');
            Route::put('/shopify-orders/update/{id}/{order_number}', 'update')->name('shopify_order_update');
            Route::post('/shopify-orders/store', 'store')->name('shopify_orders_store');
            Route::post('/shopify-orders/config', 'saveShopify-ordersConfig')->name('shopify_orders_config');
            Route::delete('/shopify-orders/destroy', 'destroy')->name('shopify_orders_destroy');
            Route::post('/shopify-orders/{id}', [ShopifyOrdersController::class, 'delete_shopify-orders'])->name('shopify_orders_delete');
            Route::get('/shopify-orders/{id}', 'show')->name('shopify_orders_show');
            Route::post('/shopify-orders/update-status/{id}', 'updateStatus')->name('shopify_status_update');
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
            // Route::post('/warehouse_report/{id}', [WarehouseController::class, 'delete_warehouse'])->name('warehouse_report_delete');
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
            //  Route::post('/products/update-status/{id}', 'updateStatus')->name('warehouse_status_update');

        });
        //نهاية products
        //بداية  product-details
        Route::controller(ProductDetailsController::class)->group(function () {
            Route::get('/product-details', 'index')->name('product_details_index');
            Route::get('/product-details/add', 'create')->name('product_details_create');
            Route::get('/product-details/edit/{id}', 'edit')->name('product_details_edit');
            Route::post('/product-details/update', 'updateproduct-details')->name('product_details_update');
            Route::post('/product-details/store', 'store')->name('product_details_store');
            Route::post('/product-details/config', 'saveproduct-detailsConfig')->name('product_details_config');
            Route::delete('/product-details/destroy/{id}', 'destroy')->name('product_details_destroy');
            Route::post('/product-details/{id}', [ProductDetailsController::class, 'delete_product-details'])->name('product_details_delete');
            Route::get('/product-details/{id}', 'show')->name('product_details_show');
            Route::post('/product-details/search', 'search')->name('product_details_search');
            //  Route::post('/product-details/update-status/{id}', 'updateStatus')->name('warehouse_status_update');

        });
        //نهاية product-details
        //بداية  transfer
        Route::controller(TransferController::class)->group(function () {
            Route::get('/transfer', 'index')->name('transfer_index');
            Route::get('/transfer/add', 'create')->name('transfer_create');
            Route::get('/transfer/edit/{id}', 'edit')->name('transfer_edit');
            Route::put('/transfer/update/{id}', 'update')->name('transfer_update');
            Route::post('/transfer/store', 'store')->name('transfer_store');
            Route::post('/transfer/config', 'savetransferConfig')->name('transfer_config');
            Route::delete('/transfer/destroy/{id}', 'destroy')->name('transfer_destroy');
            Route::post('/transfer/{id}', [TransferController::class, 'delete_transfer'])->name('transfer_delete');
            Route::get('/transfer/{id}', 'show')->name('transfer_show');
            //Route::post('/transfer/update-status/{id}', 'updateStatus')->name('warehouse_status_update');

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
            //Route::post('/transfer-products/{id}', [TransferController::class, 'delete_transfer'])->name('transfer_product_delete');
            Route::get('/transfer-products/{id}', 'show')->name('transfer_product_show');
            //Route::post('/transfer-products/update-status/{id}', 'updateStatus')->name('warehouse_status_update');

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

            Route::get('/shipments/create-shopify/{order}', 'createShopifyShipment')->name('shipments_create_shopify');


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

            Route::get('shipment/assign-by-scan', 'assignToRiderByScan')->name('shipments_assign_to_rider_by_scan');
            Route::post('shipment/assign-by-scan-qr', 'assignToRiderByScanQr')->name('shipments_assign_to_rider_by_scan_qr');

            Route::post('shipments/remove_rider', 'shipments_remove_rider')->name('shipments_remove_rider');

            Route::get('shipment/vendor_stickers', 'multi_stickers')->name('shipment_vendor_stickers');
            Route::post('shipment/print_vendor_stickers', 'printVendorStickers')->name('shipment_print_vendor_stickers');

            Route::get('shipment/vendor_invoices', 'multi_invoices')->name('shipment_vendor_invoices');
            Route::post('shipment/print_vendor_invoices', 'printVendorInvoices')->name('shipment_print_vendor_invoices');

            Route::post('shipment/search', 'search')->name('shipment.search');


            Route::get('shipment/vendors', 'vendorsShipment')->name('shipment.vendorsShipment');

            Route::get('/downloadfile', 'downloadfile')->name('shipment.downloadfile');
            Route::post('shipment/import', 'import')->name('shipment.import');
        });
        //end shipments

        //reports
        Route::controller(ReportController::class)->group(function () {
            Route::get('shipment/report', 'shipmentsReport')->name('shipments_report');
            Route::get('/payments/report', 'paymentsReport')->name('reports_payments');
            Route::get('/payments/report/branches', 'paymentsReportBranches')->name('reports_payments_branches');

            Route::get('claim_invoice', 'claimInvoice')->name('claim_invoice');
            Route::post('print_claim_invoice', 'printClaimInvoice')->name('print_claim_invoice');

            Route::get('emirate_post', 'emirate_post')->name('emirate_post');
            Route::post('emirate_post/download', 'emirate_post_export')->name('emirate_post_download');


            Route::post('payments/download', 'payments_export')->name('payments_download');
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

        Route::controller(RecivedController::class)->group(function(){
            Route::get('/recived_shipment', 'index')->name('recived_shipment_index');
            Route::get('/recived_shipment/add', 'create')->name('recived_shipment_create');
            Route::get('/recived_shipment/edit/{id}', 'edit')->name('recived_shipment_edit');
            Route::post('/recived_shipment/update', 'update')->name('recived_shipment_update');
            Route::post('/recived_shipment/store', 'store')->name('recived_shipment_store');
            Route::post('/recived_shipment/config', 'saveShopifyConfig')->name('recived_shipment_config');
            Route::delete('/recived_shipment/destroy', 'destroy')->name('recived_shipment_destroy');
            //Route::post('/recived_shipment/{id}', [recived_shipmentController::class, 'delete_shopify'])->name('recived_shipment_delete');
            Route::get('/recived_shipment/{id}', 'show')->name('recived_shipment_show');
            Route::post('/recived_shipment/update-status/{id}', 'updateStatus')->name('recived_shipment_status_update');
        });

        Route::controller(RiderLocationController::class)->group(function () {
            Route::get('rider_location', 'index')->name('rider_location');
            Route::get('rider_location_response', 'show')->name('rider_location_response');
        });


    }); //end admin auth area







});
require __DIR__ . '/auth.php';
