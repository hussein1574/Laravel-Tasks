<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'getOrdersAbove500']);
Route::get('/users/{id}/orders', [\App\Http\Controllers\OrderController::class, 'getUserOrders']);
Route::get('/products/top3', [\App\Http\Controllers\OrderItemsController::class, 'getTheMost3Products']);
Route::get('/make-order', [\App\Http\Controllers\OrderController::class, 'makeOrder']);