<?php

namespace App\Services;

use App\Models\Rooms;
use App\Models\RoomTypes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

   class SearchAvailable {
      /**
       * Algoritms
       */

      // 1. get type of each rooms that are unvailable   
      // 2. check types of rooms that are unavailable      
      // 3. get all rooms of each roomtypes.    
      // 4. match roomtypes with with all data, and substract num rooms that are unavailable
      // 5. return new data after matching

      /**
       * search for available roomtypes + num of rooms based on range date + num guests.
       */      
      public function searchAvailable(Request $request) {
         $roomtypes = RoomTypes::all();
         $numOfRooms = $request->numOfRooms;

         // count num of rooms for each roomtypes
         $roomtypes = Rooms::select('room_types_id', DB::raw('count(*) as count'))
            ->groupBy('room_types_id')
            ->with('roomtype')
            ->get();

         // get unavailable rooms for range date.
         $numUnAvailable = AvailabilityChecker::getUnavailableRoomsForDate($request->check_in, $request->check_out);

         // modify is_available
         foreach($numUnAvailable as &$room) 
               $room['is_available'] = 0;

         // match roomtypes with with all data, and substract num rooms that are unavailable
         foreach($numUnAvailable as &$room) {
            $room_type_id = $room['room_types_id'];
            $unavailable_count = $room['count'];
            foreach($roomtypes as &$count) {
                if ($count['room_types_id'] == $room_type_id) {
                    $count['count'] -= $unavailable_count;
                }
            }
         }

         $filteredRoomTypes = array_filter($roomtypes->toArray(),  function($roomtype) use ($numOfRooms) {
            return $roomtype['roomtype']['num_guest'] >= $numOfRooms;
         });

         // Not Done Yet, Next Implementation:
         // get data according to num of rooms, 2, 3, 5. if there is not rooms that are exist should available and also num of adults.
         // calculate price according to duration of staying, and num of rooms.
         // unavailable button algoritms, check if requst->numRooms > count. ==> display unavailable.

         foreach($filteredRoomTypes as &$room) 
            $room['total_price'] = intval($this->calculateTotalPrice($request->check_in, $request->check_out, $request->numOfRooms)) * $room['roomtype']['price'];


         return $filteredRoomTypes;
      }


   /**
    * Calculate the total price of a reservation.
    *
    * @param  Request  $request
    * @return Response
    */
   public function calculateTotalPrice($check_in, $check_out, $numRooms)
   {
      // Parse the arrival and departure dates from the request
      $arrivalDate = Carbon::parse($check_in);
      $departureDate = Carbon::parse($check_out);

      // Get the price and number of nights from the room type and dates
      $numNights = $arrivalDate->diffInDays($departureDate);

      // Calculate the total price
      $totalPrice = $numRooms * $numNights;

      return $totalPrice;
   }
}