<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\Dashboard\TripController;
use App\Http\Controllers\Api\Dashboard\BusesController;
use App\Http\Controllers\Api\Frontend\BookingController;
use App\Http\Controllers\Api\Frontend\SeatInfoController;
use App\Http\Controllers\Api\Dashboard\CategoryController;
use App\Http\Controllers\Api\Dashboard\LocationController;
use App\Http\Controllers\Api\Dashboard\NotificationController;
use App\Http\Controllers\Api\Dashboard\TransportationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('auth')->group(function() {
    Route::controller(UserController::class)
    ->prefix('admin')
    ->group( function () {
        Route::post('/login','login');
        Route::post('/register','register');
        Route::post('/logout','logout');
        // Route::post('/refresh','refresh');
        Route::get('/profile','userProfile');
    });
});

Route::get('/category',[CategoryController::class,'index']);
Route::get('/category/show/{category}',[CategoryController::class,'show']);
Route::get('/location',[LocationController::class,'index']);
Route::get('/location/show/{location}',[LocationController::class,'show']);
Route::get('/notification',[NotificationController::class,'index']);
Route::get('/notification/show/{notification}',[NotificationController::class,'show']);
Route::get('/trip',[TripController::class,'index']);
Route::get('/trip/show/{trip}',[TripController::class,'show']);
Route::get('/bus/show/{bus}',[BusesController::class,'show']);
Route::post('/booking/store',[BookingController::class,'store']);

Route::fallback(function() {
    return "This url is not found";
});

require __DIR__.'/dashboard.php';

