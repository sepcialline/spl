<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ChartOfAccountsController;

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

Route::prefix('branch')->name('branch.')->group(function () {

    // Route::get('login', [AuthController::class, 'Login'])->name('login.form'); // روت تسجيل الدخول للادارة
    // Route::post('/login/check', [AuthController::class, 'LoginRequest'])->name('check.login'); // روت التحقق من المستخدم و صلاحية
    // Route::get('forget', [AuthController::class, 'Forget'])->name('forget_password');
    // Route::post('forget/password', [AuthController::class, 'store'])->name('reset_password_link');


   Route::middleware(['branch'])->group(function () {  //admin auth area



    //     Route::get('/logout', [AuthController::class, 'Logout'])->name('logout'); // Logout Route

    //     // Start Dashboard
    //     Route::get('/', [DashboardController::class, 'index'])->name('index'); // روت تسجيل الدخول للادارة
    //     Route::get('/dashboard', [DashboardController::class, 'index'])->name('index'); // روت تسجيل الدخول للادارة
    //      // End Dashboard






    //     // Start Cshrt  of accounts
    //     Route::get('/account/Index', [ChartOfAccountsController::class, 'index'])->name('account.Index'); // روت تسجيل الدخول للادارة
    //     Route::get('/account/chart/create', [ChartOfAccountsController::class, 'create'])->name('account.create'); // روت تسجيل الدخول للادارة
    //     // End Cshrt  of accounts


        }); //end admin auth area






});
require __DIR__.'/auth.php';
