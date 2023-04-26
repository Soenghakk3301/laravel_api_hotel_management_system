<?php 

namespace App\Services;

use App\Models\RoomReservation;
use App\Models\Rooms;
use Illuminate\Support\Collection;

class AvailabilityChecker
{
    public static function getUnavailableRooms(string $checkInDate, string $checkOutDate, array $roomBookings): Collection
    {
        $bookedRoomIds = RoomReservation::whereHas('reservation', function ($query) use ($checkInDate, $checkOutDate) {
            $query->whereBetween('check_in', [$checkInDate, $checkOutDate])
                  ->orWhereBetween('check_out', [$checkInDate, $checkOutDate])
                  ->orWhere(function ($query) use ($checkInDate, $checkOutDate) {
                    $query->where('check_in', '<=', $checkInDate)
                          ->where('check_out', '>=', $checkOutDate);
                });
        })->pluck('room_id');

        $unavailableRooms = collect($roomBookings)->pluck('room_id')->intersect($bookedRoomIds);

        return $unavailableRooms;
    }



    public static function getAvailableRoomsForDateRange($checkInDate, $checkOutDate)
    {
      $bookedRooms = RoomReservation::whereHas('reservation', function ($query) use ($checkInDate, $checkOutDate) {
         $query->where(function ($query) use ($checkInDate, $checkOutDate) {
               $query->where('check_in_date', '>=', $checkInDate)
                  ->where('check_in_date', '<', $checkOutDate);
         })->orWhere(function ($query) use ($checkInDate, $checkOutDate) {
               $query->where('check_out_date', '>', $checkInDate)
                  ->where('check_out_date', '<=', $checkOutDate);
         })->orWhere(function ($query) use ($checkInDate, $checkOutDate) {
               $query->where('check_in_date', '<', $checkInDate)
                  ->where('check_out_date', '>', $checkOutDate);
         });
      })->pluck('room_id')->unique();

      $availableRooms = Rooms::whereNotIn('id', $bookedRooms)->get();

      return $availableRooms;
    }   


    public static function getUnavailableRoomsForDateRange($checkInDate, $checkOutDate)
    {
      $bookedRooms = RoomReservation::whereHas('reservation', function ($query) use ($checkInDate, $checkOutDate) {
         $query->where(function ($query) use ($checkInDate, $checkOutDate) {
               $query->where('check_in', '>=', $checkInDate)
                  ->where('check_in', '<=', $checkOutDate);
         })->orWhere(function ($query) use ($checkInDate, $checkOutDate) {
               $query->where('check_out', '>=', $checkInDate)
                  ->where('check_out', '<=', $checkOutDate);
         })->orWhere(function ($query) use ($checkInDate, $checkOutDate) {
               $query->where('check_in', '<', $checkInDate)
                  ->where('check_out', '>', $checkOutDate);
         });
      })->pluck('room_id')->unique();

      // $unavailableRooms = Rooms::whereIn('id', $bookedRooms)->get()->toArray();

      $unavailableRooms = $bookedRooms->toArray();

      return $unavailableRooms;
    }   
}