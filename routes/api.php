<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;

// Devices Routes
Route::prefix('device')->as('device.')->group(function () {
    // Route ==> Change device language
    Route::post('change-language', [DeviceController::class, 'postChangeLanguage'])->name('change-language');

    // Route ==> Device Register
    Route::post('register', [DeviceController::class, 'postRegister'])->name('register');

    // Route ==> Check Subscription
    Route::get('check-subscription', [DeviceController::class, 'getCheckSubscription'])->name('check-subscription');
});

// Purchases Routes
Route::prefix('purchase')->as('purchase')->group(function () {
    // Route ==> Purchase
    Route::post('/', [PurchaseController::class, 'postPurchase'])->name('purchase');

    // Route ==> Recovery Purchase
    Route::post('/recovery', [PurchaseController::class, 'postRecoveryPurchase'])->name('recovery');
});
