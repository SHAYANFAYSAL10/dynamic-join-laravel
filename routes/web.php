<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DynamicDependentController;
use App\Http\Controllers\Automatic;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\ReportController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/product', [ProductController::class, 'store'])->name('product.store');

Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');

Route::get('/dynamicview', [DynamicDependentController::class, 'index'])->name('dynamicInfoViewer.index');
Route::post('/dynamicview/fetch', [DynamicDependentController::class, 'fetch'])->name('dynamicInfoViewer.fetch');
Route::post('/dynamicview/fetch_datas', [DynamicDependentController::class, 'fetch_datas'])->name('dynamicInfoViewer.fetch_datas');

Route::get('/automatic', [Automatic::class, 'index'])->name('automatic.index');
Route::post('/automatic/fetch', [Automatic::class, 'fetch'])->name('automatic.fetch');
Route::post('/automatic/fetch_datas', [Automatic::class, 'fetch_datas'])->name('automatic.fetch_datas');

Route::get('/join', [JoinController::class, 'index'])->name('dynamicJoin.index');
Route::post('/join/fetch', [JoinController::class, 'fetch'])->name('dynamicJoin.fetch');
Route::post('/join/fetch_datas', [JoinController::class, 'fetch_datas'])->name('dynamicJoin.fetch_datas');
Route::post('/join/fetch_join_datas', [JoinController::class, 'fetch_join_datas'])->name('dynamicJoin.fetch_join_datas');
Route::post('/join', [JoinController::class, 'processForm'])->name('dynamicJoin.processForm');

Route::get('/view-report', [ReportController::class, 'index']);
