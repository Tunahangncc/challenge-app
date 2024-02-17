<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::as('api.')->group(function () {
    Route::post('register', [APIController::class, 'postRegister'])->name('register');
    Route::post('purchase', [APIController::class, 'postPurchase'])->name('purchase');
    Route::post('check-subscription', [APIController::class, 'postCheckSubscription'])->name('check-subscription');
});
