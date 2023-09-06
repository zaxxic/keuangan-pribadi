<?php

use App\Http\Controllers\AuthenticationController;
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


Route::get('/income', function () {
    return view('User.transaction.income');
})->name("income");

Route::get('/income-recurring', function () {
    return view('User.transaction.income-recurring');
})->name("income-recurring");

Route::get('/add-income', function () {
    return view('User.transaction.add-income');
})->name("add-income");

Route::get('/add-expenditure', function () {
    return view('User.transaction.add-expenditure');
})->name("add-expenditure");

Route::get('/setting', function () {
    return view('User.menu.settings');
})->name("setting");

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

Route::group(['middleware' => 'admin'], function () {
});
