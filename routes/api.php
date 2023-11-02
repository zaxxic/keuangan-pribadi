<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\VerifikasiOtpController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\Transaction\ExpenditureController;
use App\Http\Controllers\Api\Transaction\IncomeController;
use App\Http\Controllers\CallBackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('callback', [CallBackController::class, 'handle']);
Route::post('auth/register', [RegisterController::class, 'register']);
Route::post('auth/login', [LoginController::class, 'login']);
Route::post('auth/logout', [LoginController::class, 'logout']);

Route::get('dashboard', [DashboardController::class, 'index']);
Route::middleware(
    'auth:sanctum',
    'userApi'
)->group(function () {
    //income 
    Route::get('/income', [IncomeController::class, 'index']);
    Route::get('/income/edit/{id}', [IncomeController::class, 'edit']);
    Route::put('/income/update/{id}', [IncomeController::class, 'update']);
    Route::post('/income/store', [IncomeController::class, 'store']);
    Route::get('/income/category/create', [IncomeController::class, 'category']);
    Route::post('/income/category/store', [IncomeController::class, 'storeCategory']);
    // income done

    // expenditure
    Route::get('/expenditure', [ExpenditureController::class, 'index']);
    Route::get('/expenditure/edit/{id}', [ExpenditureController::class, 'edit']);
    Route::post('/expenditure/store', [ExpenditureController::class, 'store']);
    Route::put('/expenditure/update/{id}', [ExpenditureController::class, 'update']);
    Route::get('/expenditure/category', [ExpenditureController::class, 'category']);
    Route::post('/expenditure/category/store', [ExpenditureController::class, 'storeCategory']);

    // expenditure end

});
Route::middleware(
    'auth:sanctum',
)->group(function () {
    Route::post('/verify', [VerifikasiOtpController::class, 'verify']);
    Route::post('/resend', [VerifikasiOtpController::class, 'resend']);
    // Route::get('email/verify', [VerifikasiOtpController::class, 'verifyInd']);
});
