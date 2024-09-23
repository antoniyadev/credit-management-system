<?php

use App\Http\Controllers\Api\CreditController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\RecipientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('credits/for-payment', [CreditController::class, 'fetchAllForPayment'])->name('credits.for-payment');
Route::apiResource('credits', CreditController::class)->only('store', 'index', 'show');;

Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');

Route::get('recipients', [RecipientController::class, 'index']);