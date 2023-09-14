<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ExpenditureCategoryController;
use App\Http\Controllers\IncomeCategoryController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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



// Route::get('/register', [AuthenticationController::class, 'registerIndex']);

Route::get('/expenditure', function () {
    return view('User.transaction.expenditure');
})->name("expenditure");



Route::get('/income-recurring', function () {
    return view('User.transaction.income-recurring');
})->name("income-recurring");


Route::get('/add-expenditure', function () {
    return view('User.transaction.add-expenditure');
})->name("add-expenditure");



Route::get('/total', function () {
    return view('User.menu.total');
})->name("total");

Route::middleware(['auth'])->group(function () {
});


Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();


Route::get('/', function () {
    return view('User.dashboard');
})->name("dashboard");

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/calendar', function () {
    return view('User.menu.calendar');
})->name('calendar');

Route::get('/admin-dashboard', function () {
    return view('Admin.dashboard');
})->name('admin');

Route::get('paid-users', function () {
    return view('Admin.users');
})->name('paid-users');

Route::group(['middleware' => 'user'], function () {

    Route::get('/profile', [ProfileController::class, 'index'])->name('setting');
    Route::put('/profile.update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password.update', [ProfileController::class, 'updatePassword'])->name('password.update');

    Route::resource('income_category', IncomeCategoryController::class)->except(['show', 'edit', 'create']);
    Route::resource('expenditure_category', ExpenditureCategoryController::class)->except(['show', 'edit', 'create']);
    Route::resource('income', IncomeController::class)->except(['show,edit']);
    // Route::get('income/edit/{transaction_id}', 'IncomeController@edit')->name('income.editing');
    Route::get('/income/edit/{id}', [IncomeController::class, 'editing'])->name('income.editing');


    Route::get('/in-category', [IncomeController::class, 'category'])->name('in-category');
    Route::post('/store-category', [IncomeController::class, 'storeCatgory'])->name('store-category');
});
