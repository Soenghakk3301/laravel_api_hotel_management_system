<?php

namespace App\Http\Controllers\V1;

use App\Models\RoomReservation;
use App\Http\Requests\V1\StoreRoomReservationRequest;
use App\Http\Requests\V1\UpdateRoomReservationRequest;
use App\Http\Resources\V1\RoomReservationResource;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Rooms;
use App\Models\RoomTypes;
use App\Models\transaction;
use App\Services\AvailabilityChecker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;



class RoomReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RoomReservationResource::collection(RoomReservation::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoomReservationRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreRoomReservationRequest $request)
    {
      $validatedData = $request->validated();

      $message = 'One or more of the selected rooms are not available during the requested booking period';

      $roomtypes = RoomTypes::with('rooms')->where('name', $request->roomtype)->get();

      $num_rooms = RoomTypes::with('rooms')
                              ->where('name', $request->roomtype)
                              ->get()
                              ->flatMap(function ($roomtype) {
                                 return $roomtype->rooms;
                              })
                              ->count();


      $roomtypes['total_rooms'] = $num_rooms;


      // get unavailable rooms of date ranges
      $unavailableRooms = AvailabilityChecker::getUnavailableRooms(
                           $validatedData['check_in'], 
                           $validatedData['check_out'], 
                        )->toArray();

      // return $unavailableRooms;

      /**
       * Need to be fixed, when implement with real data, we use id of roomtypes, this id will dynamic.
       */
      // get all id of rooms that available of roomtype
      $rooms = Rooms::where('room_types_id', 1)->pluck('id')->toArray();

      $num_rooms = $request->num_rooms;
      
      // select only rooms that are not match with $unavailableRooms
      $room_bookings = array_filter($rooms, function($room) use ($unavailableRooms) {
         return !in_array($room, $unavailableRooms);
      });
     
      $room_bookings = array_slice($room_bookings, 0, $num_rooms);

      // Make new Reservation
      $reservation = new Reservation();
      $reservation->check_in = $validatedData['check_in'];
      $reservation->check_out = $validatedData['check_out'];

      // Guest Object.
      $guest = new Guest();
      $guest->name = $validatedData['guest_name'];
      $guest->email = $validatedData['guest_email'];
      $guest->phon_number = $validatedData['guest_phone_number'];
      $guest->save();
     
      $reservation->guest_id = $guest->id; // Set guest ID
      $reservation->save();

      $amount = $request->amount / $request->num_rooms;

      // save record of one or more rooms that guest has booked.
      foreach ($room_bookings as $roomReservationData) {
          $roomReservation = new RoomReservation();
          $roomReservation->room_id = $roomReservationData;
          $reservation->roomReservation()->save($roomReservation);

          // working with transaction
          $transaction = new transaction();
          $transaction->guest_id = $guest->id;
          $transaction->room_reservation_id = $roomReservation->id;
          $transaction->amount = $amount;
          $transaction->save();
      }

      $reservation->load(['guest', 'roomReservation.room']);

      return response()->json(['data' => $reservation], 201);
    }



   /**
    * Calculate the total price of a reservation.
    *
    * @param  Request  $request
    * @return Response
    */
   public function calculateTotalPrice(Request $request)
   {
      // Parse the arrival and departure dates from the request
      $arrivalDate = Carbon::parse($request->input('checkIn'));
      $departureDate = Carbon::parse($request->input('checkOut'));

      // Get the number of rooms and the room type from the request
      $numRooms = $request->input('num_rooms');
      $roomType = $request->input('room_type');

      // Get the price and number of nights from the room type and dates
      $roomTypePrice = $roomType['price'];
      $numNights = $arrivalDate->diffInDays($departureDate);

      // Calculate the total price
      $totalPrice = $roomTypePrice * $numRooms * $numNights;

      // Return a JSON response containing the total price
      return response()->json([
         'total_price' => $totalPrice
      ]);
   }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoomReservation  $roomReservation
     * @return \Illuminate\Http\Response
     */
    public function show(RoomReservation $roomreservation)
    {
        return new RoomReservationResource($roomreservation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoomReservationRequest  $request
     * @param  \App\Models\RoomReservation  $roomReservation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoomReservationRequest $request, RoomReservation $roomReservation)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoomReservation  $roomReservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomReservation $roomreservation)
    { 
      $roomreservation->delete();
    }
}