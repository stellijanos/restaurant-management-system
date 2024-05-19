<?php

use App\Http\Controllers\Cashier\CashierController;
use App\Http\Controllers\Management\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/management', function() {
    return view('management.index');
});

Route::get('/cashier', [CashierController::class, 'index']);

Route::get('/cashier/get-tables', [CashierController::class, 'getTables']);


Route::resource('management/category', 'App\Http\Controllers\Management\CategoryController');
Route::resource('management/menu', 'App\Http\Controllers\Management\MenuController');
Route::resource('management/table','App\Http\Controllers\Management\TableController');
