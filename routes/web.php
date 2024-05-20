<?php

use App\Http\Controllers\Cashier\CashierController;
use App\Http\Controllers\Management\CategoryController;
use App\Http\Controllers\Management\MenuController;
use App\Http\Controllers\Management\TableController;
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
Route::get('/cashier/get-menu-by-category/{category_id}',[CashierController::class, 'getMenuByCategory']);
Route::get('/cashier/get-tables', [CashierController::class, 'getTables']);
Route::get('/cashier/get-sale-details-by-table/{table_id}',[CashierController::class, 'getSaleDetailsByTable']);

Route::post('/cashier/order-food', [CashierController::class, 'orderFood']);



Route::resource('management/category', CategoryController::class);
Route::resource('management/menu', MenuController::class);
Route::resource('management/table', TableController::class);
