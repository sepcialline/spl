<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\VendorApi\Auth\AuthController;
use App\Http\Controllers\API\VendorApi\ProfileController;
use App\Http\Controllers\API\VendorApi\ShipmentController;

Route::prefix('/vendor')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    // Route لإرسال OTP
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

    // Route للتحقق من OTP
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});


Route::middleware('auth:sanctum')->prefix('/vendor')->group(function () {
    Route::controller(ProfileController::class)->group(function () {

        Route::get('/get_vendor_companies', 'getVendorCompanies');
        Route::get('/get_current_company/{id}', 'get_current_company');
    });

    Route::prefix('company')->controller(ShipmentController::class)->group(function () {
        Route::get('/get_shipment_summary/{company_id}', 'shipment_summary');
        Route::get('/get_status_list', 'shipment_status_list');
        Route::get('/get_emirate_list', 'emirate_list');
        Route::post('/get_shipments', 'shipments');
        Route::post('/search_shipments', 'search');
        Route::get('/get_shipment_details/{shipment_id}', 'get_shipment_details');
    });
});
