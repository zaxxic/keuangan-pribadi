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

Route::get('/emailed/verify', function () {
  return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
  $request->fulfill();
  return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');


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
Route::group(['middleware' => 'user'], function () {

  //notifikasi
  Route::resource('/notif', NotificationController::class);



  Route::get('/', [UserController::class, 'index'])->name('home');
  Route::get('/home', [UserController::class, 'index'])->name('home');
  Route::post('/gethistory', [UserController::class, 'getHistory'])->name('gethistory');
  Route::get('/export/{bulan}', [UserController::class, 'export'])->name('export');

  Route::get('/profile', [ProfileController::class, 'index'])->name('setting');
  Route::put('/profile.update', [ProfileController::class, 'update'])->name('profile.update');
  Route::put('/password.update', [ProfileController::class, 'updatePassword'])->name('password.update');

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

Route::get('/detail-tabungan', function () {
  return view('User.transaction.savings.detail-tabungan');
})->name('savings.detail');
Route::get('/savings', function () {
  return view('User.transaction.savings.index');
})->name('savings');
Route::get('/savings/create', function () {
  return view('User.transaction.savings.add-savings');
})->name('savings.create');
