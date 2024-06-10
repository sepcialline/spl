<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Rider\AuthController;
use App\Http\Controllers\Rider\DashboardController;


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

Route::prefix('rider')->name('rider.')->group(function () {

    Route::get('login', [AuthController::class, 'Login'])->name('login.form'); // روت تسجيل الدخول
    Route::post('/login/check', [AuthController::class, 'LoginRequest'])->name('check.login'); // روت التحقق من المستخدم و صلاحية



    Route::middleware(['rider'])->group(function () {  //rider auth area



        Route::get('/logout', [AuthController::class, 'Logout'])->name('logout'); // Logout Route

        // Start Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('index'); // روت تسجيل الدخول للادارة
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('index'); // روت تسجيل الدخول للادارة
         // End Dashboard


        }); //end rider auth area
});
require __DIR__.'/auth.php';
