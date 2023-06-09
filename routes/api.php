<?php

use App\Http\Controllers\V1\AddOnServicesController;
use App\Http\Controllers\V1\AuthenticateController;
use App\Http\Controllers\V1\ImagesController;
use App\Http\Controllers\V1\RoomsController;
use App\Http\Controllers\V1\RoomTypesController;
use App\Http\Controllers\V1\ServicesController;
use App\Http\Controllers\V1\UserTypesController;
use App\Http\Controllers\V1\RoomReservationController;
use App\Http\Controllers\V1\TransactionController;
use App\Services\SearchAvailable;
use Illuminate\Support\Facades\Route;

// private routes
Route::apiResource('roomtypes', RoomTypesController::class)
      ->only(['store', 'destroy', 'update'])
      ->middleware(['auth:sanctum', 'role:admin,stuff']);
// public routes of roomtypes
Route::apiResource('roomtypes', RoomTypesController::class)
     ->only(['index', 'show']);

// Route::apiResource('roomtypes', RoomTypesController::class);

Route::apiResource('images', ImagesController::class)
      ->only(['store', 'destroy', 'update'])
      ->middleware(['auth:sanctum', 'role:admin,stuff']);
// public routes of images
Route::apiResource('images', ImagesController::class)
      ->only(['index', 'show']);

Route::apiResource('add_service_roomtypes', AddOnServicesController::class)
      ->only(['store', 'destroy', 'update'])
      ->middleware(['auth:sanctum', 'role:admin']);


Route::apiResource('usertypes', UserTypesController::class)->middleware(['auth:sanctum', 'role:admin']);

Route::apiResource('rooms', RoomsController::class)
      ->only(['store', 'update', 'destroy'])
      ->middleware(['auth:sanctum', 'role:admin']);
Route::apiResource('rooms', RoomsController::class)->only(['index', 'show']);

Route::apiResource('room_reservations', RoomReservationController::class);
Route::apiResource('transactions', TransactionController::class)->middleware('auth:sanctum');


/**
 * special routes, public routes
 */
Route::get('reservations/searchAvailable', [SearchAvailable::class, 'searchAvailable']);
Route::post('reservations/addBooking/searchAvailable', [SearchAvailable::class, 'searchAvailable']);


//////////////// ROUTES OF AUTHENTICATE //////////////
// public routes

Route::post('/register', [AuthenticateController::class, 'register']);
Route::post('/login', [AuthenticateController::class, 'login']);

// private route
Route::post('/logout', [AuthenticateController::class, 'logout'])->middleware('auth:sanctum');

//////////////// END OF ROUTES AUTHENTICATE //////////////

//// Services ////
Route::apiResource('services', ServicesController::class)
      ->only(['store', 'update', 'destroy'])
      ->middleware(['auth:sanctum', 'role:admin,stuff']);

// public routes //
Route::apiResource('services', ServicesController::class)
->only(['index', 'show']);