<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\VerifikasiOtpController;
use App\Http\Controllers\Api\DashboardController;
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
    Route::get('/income', [IncomeController::class, 'index']);
    Route::get('/income/edit/{id}', [IncomeController::class, 'edit']);
    Route::put('/income/update/{id}', [IncomeController::class, 'update']);
    // Route::get('/income/create', [IncomeController::class, 'index']);
    Route::post('/income/store', [IncomeController::class, 'store']);
    Route::get('/income/categor/create', [IncomeController::class, 'category']);
    Route::post('/income/category/store', [IncomeController::class, 'storeCategory']);
});
Route::middleware(
    'auth:sanctum',
)->group(function () {
    Route::post('/verify', [VerifikasiOtpController::class, 'verify']);
    Route::post('/resend', [VerifikasiOtpController::class, 'resend']);
    // Route::get('email/verify', [VerifikasiOtpController::class, 'verifyInd']);
});
