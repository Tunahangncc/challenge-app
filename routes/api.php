<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\PurchaseController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::as('api.')->group(function () {
    // Change Lang
    Route::post('change-lang', [APIController::class, 'getChangeLang'])->name('change-lang');

    // Purchase Routes
    Route::post('purchase', [PurchaseController::class, 'postPurchase'])->name('purchase');
    Route::post('recovery-purchase', [PurchaseController::class, 'postRecoveryExpireDate'])->name('recovery-purchase');

    Route::post('register', [APIController::class, 'postRegister'])->name('register');
    Route::post('check-subscription', [APIController::class, 'postCheckSubscription'])->name('check-subscription');
});
