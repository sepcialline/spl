<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\GetUserController;
use App\Http\Controllers\API\CarPlate\CarPlateController;
use App\Http\Controllers\API\Dashboard\DashboardController;
use App\Http\Controllers\API\Emirates\EmiratesController;
use App\Http\Controllers\API\Expenses\ExpensesController;
use App\Http\Controllers\API\ExpenseType\ExpenseTypeController;
use App\Http\Controllers\API\PaymentType\PaymentTypeController;
use App\Http\Controllers\API\RiderLocationController;
use App\Http\Controllers\API\Search\SearchController;
use App\Http\Controllers\API\Shipment\ShipmentController;
use App\Http\Controllers\API\Shipment\ShipmentOperationsController;
use App\Http\Controllers\API\ShipmentStatus\ShipmentStatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/get-user', [AuthController::class, 'user']);
    Route::get('/current-user', [GetUserController::class, 'index']);
    Route::apiResource('/expenses', ExpensesController::class);
    Route::apiResource('/dashboard', DashboardController::class);
    Route::apiResource('/search', SearchController::class);
    Route::apiResource('/shipments', ShipmentController::class);
    Route::apiResource('/shipment-status', ShipmentStatusController::class);
    Route::apiResource('/update-shipment', ShipmentOperationsController::class);
    Route::apiResource('/emirates', EmiratesController::class);
    Route::apiResource('/expense_types', ExpenseTypeController::class);
    Route::apiResource('/car_plates', CarPlateController::class);
    Route::apiResource('/payment_types', PaymentTypeController::class);
    Route::post('/update_order', [ShipmentController::class, 'updateOrderStatus']);



});
