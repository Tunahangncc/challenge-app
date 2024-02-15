<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [APIController::class, 'postRegister']);
Route::post('purchase', [APIController::class, 'postPurchase']);
Route::post('check-subscription', [APIController::class, 'postCheckSubscription']);
