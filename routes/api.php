<?php

use App\Http\Controllers\V1\AddOnServicesController;
use App\Http\Controllers\V1\ImagesController;
use App\Http\Controllers\V1\RoomsController;
use App\Http\Controllers\V1\RoomTypesController;
use App\Http\Controllers\V1\ServicesController;
use App\Http\Controllers\V1\UserTypesController;
use App\Http\Controllers\V1\RoomReservationController;
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