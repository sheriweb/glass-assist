<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::prefix('customer')->group(function () {
    Route::get('/search/name', [CustomerController::class, 'searchName'])->name('api.customer');
});
