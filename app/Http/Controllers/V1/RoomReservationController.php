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
    
     // in this case, we are focus on the process of make booking at the hotel. to make it
     // work first. And later on we will implement by online booking.
     // In this Algorithms, we add new table called " Transaction Table "
     // This table will store the amount's price of each room based on staying duration.
     


     // I've changed my mind, now i'm gonna focus on by online booking.

     // get all request data. 
     // such as: 
     // check_in, check_out, guest_name, guest_email, guest_phone_number, is_male, special_request, num_rooms, amounts
     // roomtypes,


     //// ==> divice amounts / num_rooms => price of each rooms, ==> to be stored on room_reservation's table
     //// ==> random algorithm to select available rooms,
     //// ==> check if num_rooms of a specific of roomtype has enought for booking or not.
     //// => for example if user want 3 rooms, by default 5 rooms are available, so rooms that are selected
     //// must be: 1, 2, 3, 
     //// ==> if one or two of those are not available, let's consider to, by the same example user want 3
     //// rooms, but, 2, 3 are not available anymore, so rooms are selected: 1, 4, 5.
     /// that is the format we want to think of.

    public function store(StoreRoomReservationRequest $request)
    {
      $validatedData = $request->validated();

      $message = 'One or more of the selected rooms are not available during the requested booking period';


      // dd($validatedData);

      $roomtypes = RoomTypes::with('rooms')->where('name', $request->roomtype)->get();

      $num_rooms = RoomTypes::with('rooms')
                              ->where('name', $request->roomtype)
                              ->get()
                              ->flatMap(function ($roomtype) {
                                 return $roomtype->rooms;
                              })
                              ->count();


      $roomtypes['total_rooms'] = $num_rooms;
      
      // return $roomtypes;

      // check if the rooms is available for date range
      // $unavailableRooms = AvailabilityChecker::getUnavailableRooms(
      //                         $validatedData['check_in'], 
      //                         $validatedData['check_out'], 
      //                         $validatedData['room_bookings']
      //                      )->toArray();


      // get unavailable rooms of date ranges
      $unavailableRooms = AvailabilityChecker::getUnavailableRooms(
                           $validatedData['check_in'], 
                           $validatedData['check_out'], 
                        )->toArray();

      // return $unavailableRooms;

      // get all id of rooms that available of roomtype
      $rooms = Rooms::where('room_types_id', 1)->pluck('id')->toArray();

      $num_rooms = $request->num_rooms;
      
      // select only rooms that are not match with $unavailableRooms
      $room_bookings = array_filter($rooms, function($room) use ($unavailableRooms) {
         return !in_array($room, $unavailableRooms);
      });
     
      $room_bookings = array_slice($room_bookings, 0, $num_rooms);

      // return $room_bookings;


      // Check if there is any room which is available for booking or not?
      // if ($unavailableRooms->count() > 0)
      //     return response()->json(['message' => $message], 400);
      

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