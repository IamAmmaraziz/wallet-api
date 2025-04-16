<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class, 'show']);


Route::post('/wallet/deposit/{userId}', [WalletController::class, 'deposit']);
Route::post('/wallet/withdraw/{userId}', [WalletController::class, 'withdraw']);



Route::post('/wallet/transfer/{senderId}', [TransactionController::class, 'transfer']);
Route::get('/transactions/{userId}', [TransactionController::class, 'getUserTransactions']);
