<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\BookingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Auth::routes();

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', [LoginController::class, 'apiLogin'])->name('api.login');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/bookings', [BookingController::class, 'bookings'])->name('api.user');

        Route::get('/booking/{id}', [BookingController::class, 'booking'])->name('api.technician');

        Route::put('/booking/add-sig/{id}', [BookingController::class, 'addSign'])->name('api.add-sign');

        Route::put('/booking/update/{id}', [BookingController::class, 'updateBooking'])->name('api.update-booking');
    });
});
