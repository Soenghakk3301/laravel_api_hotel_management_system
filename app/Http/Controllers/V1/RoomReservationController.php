<?php

namespace App\Http\Controllers\V1;

use App\Models\RoomReservation;
use App\Http\Requests\V1\StoreRoomReservationRequest;
use App\Http\Requests\V1\UpdateRoomReservationRequest;
use App\Http\Resources\V1\RoomReservationResource;
use App\Models\Guest;
use App\Models\Reservation;
use App\Services\AvailabilityChecker;

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

      // check if the rooms is available for date range
      $unavailableRooms = AvailabilityChecker::getUnavailableRooms(
                              $validatedData['check_in'], 
                              $validatedData['check_out'], 
                              $validatedData['room_bookings']
                           );

      if ($unavailableRooms->count() > 0)
          return response()->json(['message' => $message], 400);

      $reservation = new Reservation();
      $reservation->check_in = $validatedData['check_in'];
      $reservation->check_out = $validatedData['check_out'];

      $guest = new Guest();
      $guest->name = $validatedData['guest_name'];
      $guest->email = $validatedData['guest_email'];
      $guest->phon_number = $validatedData['guest_phone_number'];
      $guest->save();
     
      $reservation->guest_id = $guest->id; // Set guest ID
      $reservation->save();

      foreach ($validatedData['room_bookings'] as $roomReservationData) {
          $roomReservation = new RoomReservation();
          $roomReservation->room_id = $roomReservationData['room_id'];
          $reservation->roomReservation()->save($roomReservation);
      }

      $reservation->load(['guest', 'roomReservation.room']);

      return response()->json(['data' => $reservation], 201);
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