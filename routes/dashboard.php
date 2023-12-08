<?php

use App\Http\Controllers\Api\Dashboard\TripController;
use App\Http\Controllers\Api\Dashboard\BusesController;
use App\Http\Controllers\Api\Frontend\BookingController;
use App\Http\Controllers\Api\Frontend\SeatInfoController;
use App\Http\Controllers\Api\Dashboard\CategoryController;
use App\Http\Controllers\Api\Dashboard\LocationController;
use App\Http\Controllers\Api\Dashboard\NotificationController;





Route::middleware(['auth:api'])
    ->prefix('admin')->group(function() {
    Route::controller(CategoryController::class)
        ->group( function () {
            Route::post('/category/store','store');
            Route::get('/category/delete/{category}','destroy');
            Route::post('/category/update/{id}','update');
    });

    Route::controller(LocationController::class)
        ->group( function () {
            Route::post('/location/store','store');
            Route::get('/location/delete/{location}','destroy');
            Route::post('/location/update/{id}','update');
    });
    Route::controller(NotificationController::class)
        ->group( function () {
            Route::post('/notification/store','store');
            Route::get('/notification/delete/{notification}','destroy');
            Route::post('/notification/update/{id}','update');
    });


    Route::controller(TripController::class)
        ->group( function () {
            Route::post('/trip/store','store');
            Route::get('/trip/delete/{trip}','destroy');
            Route::post('/trip/update/{id}','update');
            Route::get('/trip/inventory','inventory');
    });

    Route::controller(BusesController::class)
        ->group( function () {
            Route::get('/bus','index');
            Route::post('/bus/store','store');
            Route::get('/bus/delete/{bus}','destroy');
            Route::post('/bus/update/{id}','update');
    });

    Route::controller(BookingController::class)
        ->group( function () {
            Route::get('/booking','index');
            Route::get('/booking/show/{booking}','show');
            Route::get('/booking/delete/{booking}','destroy');
    });

    Route::controller(SeatInfoController::class)
        ->group( function () {
            Route::get('/client/info','index');
    });

});
