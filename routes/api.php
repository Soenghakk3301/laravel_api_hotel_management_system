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


// admin can do all the things, like: create read update delete
// stuff can do a bit less, read, update, create.
// guest user: read, make order (create booking), 

// we will implement roles and permissions in our app, role: admin, stuff, guest. by default our app will assign role to guest,
// for the 2 other roles, these are the special roles, that these roles will only created by admin. in the system.


// Take that must be completed:
// Refactor code. Make it more and manageble.
// the return of result (json form) must be in standrad.
// Completed in 6 hours. 


// private routes
Route::apiResource('roomtypes', RoomTypesController::class);
Route::apiResource('images', ImagesController::class);
Route::apiResource('services', ServicesController::class);
Route::apiResource('add_service_roomtypes', AddOnServicesController::class);
Route::apiResource('usertypes', UserTypesController::class);
Route::apiResource('rooms', RoomsController::class);
Route::apiResource('room_reservations', RoomReservationController::class);
Route::apiResource('transactions', TransactionController::class);

                 
/**
 * special routes, public routes
 */
Route::get('reservations/searchAvailable', [SearchAvailable::class, 'searchAvailable']);
Route::post('reservations/addBooking/searchAvailable', [SearchAvailable::class, 'searchAvailable']);


/**
 * Authentication, public routes
*/
Route::post('/register', [AuthenticateController::class, 'register']);
Route::post('/login', [AuthenticateController::class, 'login']);

// private route
Route::post('/logout', [AuthenticateController::class, 'logout'])->middleware('auth:sanctum');