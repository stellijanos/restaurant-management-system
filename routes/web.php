<?php

use App\Http\Controllers\Cashier\CashierController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Management\CategoryController;
use App\Http\Controllers\Management\MenuController;
use App\Http\Controllers\Management\TableController;
use App\Http\Controllers\Management\UserController;
use App\Http\Controllers\Report\ReportController;
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

Route::get('/', [HomeController::class, 'index']);

Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function() {
   

    // Routes for cashier
    Route::get('/cashier', [CashierController::class, 'index']);
    Route::get('/cashier/get-menu-by-category/{category_id}',[CashierController::class, 'getMenuByCategory']);
    Route::get('/cashier/get-tables', [CashierController::class, 'getTables']);
    Route::get('/cashier/get-sale-details-by-table/{table_id}',[CashierController::class, 'getSaleDetailsByTable']);

    Route::post('/cashier/order-food', [CashierController::class, 'orderFood']);
    Route::post('/cashier/confirm-order-status', [CashierController::class, 'confirmOrderStatus']);
    Route::post('/cashier/delete-sale-detail', [CashierController::class, 'deleteSaleDetail']);
    Route::post('/cashier/save-payment',[CashierController::class, 'savePayment']);
    Route::get('/cashier/show-receipt/{sale_id}',[CashierController::class, 'showReceipt']);
});

Route::middleware(['auth', 'verifyAdmin'])->group(function() {

    Route::get('/management', function() {
        return view('management.index');
    });

    // Routes for management
    Route::resource('management/category', CategoryController::class);
    Route::resource('management/menu', MenuController::class);
    Route::resource('management/table', TableController::class);
    Route::resource('management/user', UserController::class);

    // Routes for report
    Route::get('/report',[ReportController::class, 'index']);
    Route::get('/report/show', [ReportController::class, 'show']);
    Route::get('/report/show/export',[ReportController::class, 'export']);
});
