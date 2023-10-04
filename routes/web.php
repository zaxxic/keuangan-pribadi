<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\RegulerIncomeController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Saving\SavingController;
use App\Http\Controllers\IncomeCategoryController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ExpenditureCategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RegulerExpenController;

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

Auth::routes(['verify' => true]);


// Route::get('/registered', [RegisteredController::class, 'index'])->name('register.home');
// Route::post('/registered', [RegisteredController::class, 'registerProses'])->name('register.proses');

// Route::get('/email/verify', function () {
//   return view('auth.verifikasi');
// })->name('verification.notice');
Route::group(['middleware' => ['auth']], function () {
  Route::get('/email/verify', [UserController::class, 'indexVerify'])->name('verification.notice');
  Route::post('/verif', [UserController::class, 'verify'])->name('verif');
  Route::get('/resend', [UserController::class, 'resend'])->name('resended');
});


Route::get('/income-recurring', function () {
  return view('User.transaction.income-recurring');
})->name("income-recurring");


Route::get('/add-expenditure', function () {
  return view('User.transaction.add-expenditure');
})->name("add-expenditure");



Route::get('/total', function () {
  return view('User.menu.total');
})->name("total");



Route::get('/login', function () {
  return view('auth.login');
});

Auth::routes();



Route::get('/admin-dashboard', function () {
  return view('Admin.dashboard');
})->name('admin');

Route::get('paid-users', function () {
  return view('Admin.users');
})->name('paid-users');

// Route::group(['middleware' => 'user', 'verified'], function () {

Route::group(['middleware' => ['verif', 'user']], function () {
  Route::get('/', [UserController::class, 'index'])->name('home');

  //notifikasi
  // Route::resource('/notif', NotificationController::class);
  Route::get('/notif', [NotificationController::class, 'index'])->name('notif.index');
  Route::post('/accept/{id}', [NotificationController::class, 'accept'])->name('accept.notifikasi');
  Route::post('/confirmation/{id}', [NotificationController::class, 'confirmation'])->name('confirmation.notifikasi');

  // Route::get('/', [UserController::class, 'index'])->name('home');
  Route::post('/gethistory', [UserController::class, 'getHistory'])->name('gethistory');
  Route::get('/export/{bulan}', [UserController::class, 'export'])->name('export');

  Route::resource('/savings', SavingController::class);
  Route::post('/invite', [SavingController::class, 'invite'])->name('invite');
  Route::get('/join', [SavingController::class, 'join'])->name('join');
  Route::get('/out/{saving}', [SavingController::class, 'out'])->name('out');
  Route::post('/kick', [SavingController::class, 'kick'])->name('kick');

  Route::get('/profile', [ProfileController::class, 'index'])->name('setting');
  Route::put('/profile.update', [ProfileController::class, 'update'])->name('profile.update');
  Route::put('/password.update', [ProfileController::class, 'updatePassword'])->name('password.updatee');

  Route::resource('income_category', IncomeCategoryController::class)->except(['show', 'edit', 'create']);
  Route::resource('expenditure_category', ExpenditureCategoryController::class)->except(['show', 'edit', 'create']);
  Route::resource('income', IncomeController::class)->except(['show,edit']);
  Route::get('/income/edit/{id}', [IncomeController::class, 'editing'])->name('income.editing');
  Route::get('/in-category', [IncomeController::class, 'category'])->name('in-category');
  Route::post('/store-category', [IncomeController::class, 'storeCatgory'])->name('store-category');

  Route::resource('/expenditure', ExpenditureController::class)->except(['show']);
  Route::get('/get-category', [ExpenditureController::class, 'category'])->name('get-category');
  Route::post('/post-category', [ExpenditureController::class, 'storeCatgory'])->name('post-category');
  Route::resource('/reguler-income', RegulerIncomeController::class)->except(['show']);
  Route::resource('/reguler-expenditure', RegulerExpenController::class)->except(['show']);
});
