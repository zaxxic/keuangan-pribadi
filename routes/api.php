<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\SettingsController;
use App\Http\Controllers\Api\Auth\VerifikasiOtpController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\TotalController;
use App\Http\Controllers\Api\Tracsaction\SavingsController;
use App\Http\Controllers\Api\Transaction\ExpenditureController;
use App\Http\Controllers\Api\Transaction\IncomeController;
use App\Http\Controllers\Api\Transaction\RegulerExpenditure;
use App\Http\Controllers\Api\Transaction\RegulerIncomeController;
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

Route::middleware(
    'auth:sanctum',
    'userApi'
)->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
    //income 
    Route::get('/income', [IncomeController::class, 'index']);
    Route::post('/income/filter', [IncomeController::class, 'filter']);
    Route::get('/income/edit/{id}', [IncomeController::class, 'edit']);
    Route::put('/income/update/{id}', [IncomeController::class, 'update']);
    Route::post('/income/store', [IncomeController::class, 'store']);
    Route::delete('/income/delete/{id}', [IncomeController::class, 'destroy']);
    Route::get('/income/category/create', [IncomeController::class, 'category']);
    Route::post('/income/category/store', [IncomeController::class, 'storeCategory']);
    // income done

    // subs
    Route::get('/subs/{id}', [SubscriberController::class, 'subscribe']);
    // subs end

    // expenditure
    Route::get('/expenditure', [ExpenditureController::class, 'index']);
    Route::get('/expenditure/edit/{id}', [ExpenditureController::class, 'edit']);
    Route::post('/expenditure/store', [ExpenditureController::class, 'store']);
    Route::put('/expenditure/update/{id}', [ExpenditureController::class, 'update']);
    Route::get('/expenditure/category', [ExpenditureController::class, 'category']);
    Route::post('/expenditure/category/store', [ExpenditureController::class, 'storeCategory']);
    Route::delete('/expenditure/delete/{id}', [IncomeController::class, 'destroy']);

    // expenditure end

    // expenditure reguler
    Route::get('/reguler/expenditure', [RegulerExpenditure::class, 'index']);
    Route::post('/reguler/store/expenditure', [RegulerExpenditure::class, 'store']);
    Route::get('/reguler/edit/expenditure/{id}', [RegulerExpenditure::class, 'edit']);
    Route::put('/reguler/update/expenditure/{id}', [RegulerExpenditure::class, 'update']);
    Route::delete('/reguler/expenditure/delete/{id}', [RegulerExpenditure::class, 'destroy']);
    //expenditure reguler end

    // income reguler
    Route::get('/reguler/income', [RegulerIncomeController::class, 'index']);
    Route::post('/reguler/store/income', [RegulerIncomeController::class, 'store']);
    Route::get('/reguler/edit/income/{id}', [RegulerIncomeController::class, 'edit']);
    Route::put('/reguler/update/income/{id}', [RegulerIncomeController::class, 'update']);
    Route::delete('/reguler/income/delete/{id}', [RegulerIncomeController::class, 'destroy']);
    //income reguler end

    // akun setings
    Route::get('/profile', [SettingsController::class, 'index']);
    Route::put('/profile/update', [SettingsController::class, 'update']);
    Route::put('/password/update', [SettingsController::class, 'updatePassword']);
    // akun settings end

    // notifikasi
    Route::get('/notif', [NotificationController::class, 'index']);
    Route::post('/accept/{id}', [NotificationController::class, 'accept']);
    Route::post('/update/notif/{id}', [NotificationController::class, 'update']);
    // notifikasi end

    //savings 
    Route::resource('/saving', SavingsController::class);
    Route::post('/invite', [SavingsController::class, 'invite']);
    Route::get('/join', [SavingsController::class, 'join'])->name('join.api');
    Route::get('/out/{saving}', [SavingsController::class, 'out']);
    Route::post('/kick', [SavingsController::class, 'kick']);
    Route::post('/setor', [SavingsController::class, 'setor']);
    Route::post('/tarik', [SavingsController::class, 'tarik']);
    //savings end

    // total 
    Route::get('/bukti', [TotalController::class, 'pembelian']);

    // total end

});
Route::middleware(
    'auth:sanctum',
)->group(function () {
    Route::post('/verify', [VerifikasiOtpController::class, 'verify']);
    Route::post('/resend', [VerifikasiOtpController::class, 'resend']);
    // Route::get('email/verify', [VerifikasiOtpController::class, 'verifyInd']);
});
