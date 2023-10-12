<?php

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

Route::get('/stocks', [\App\Http\Controllers\StockPriceController::class, 'getAllSymbols'])->name('get-all-symbols');
Route::get('/latest-stock-price/{symbol}', [\App\Http\Controllers\StockPriceController::class, 'latestStockPrice'])->name('get-latest-stock-price');