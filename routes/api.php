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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('roomtypes', RoomTypesController::class);
Route::apiResource('images', ImagesController::class);
Route::apiResource('services', ServicesController::class);
Route::apiResource('add_service_roomtypes', AddOnServicesController::class);
Route::apiResource('usertypes', UserTypesController::class);
Route::apiResource('rooms', RoomsController::class);
Route::apiResource('room_reservations', RoomReservationController::class);
Route::apiResource('transactions', TransactionController::class);

                 
/**
 * special routes
 */
Route::get('reservations/searchAvailable', [SearchAvailable::class, 'searchAvailable']);
Route::post('reservations/addBooking/searchAvailable', [SearchAvailable::class, 'searchAvailable']);


/**
 * Authentication
*/
Route::post('/register', [AuthenticateController::class, 'register']);
Route::post('/login', [AuthenticateController::class, 'login']);
Route::post('/logout', [AuthenticateController::class, 'logout'])->middleware('auth:sanctum');