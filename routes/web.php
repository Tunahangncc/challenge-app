<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

// File Export
Route::get('file-export', [ApiController::class, 'getExportFile'])->name('file-export');
