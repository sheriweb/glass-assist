<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::prefix('company')->group(function () {
    Route::get('/search/name', [CustomerController::class, 'searchCompany'])->name('api.company');
});
