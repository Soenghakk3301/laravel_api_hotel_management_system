<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      $arrivalDate = Carbon::parse($this->roomReservation->reservation->check_in);
      $departureDate = Carbon::parse($this->roomReservation->reservation->check_out);
      
        return [
            'id' => $this->id,
            'room' => $this->roomReservation->room->room_no,
            'guestEmail' => $this->guest->email,
            'amount' => $this->amount,
            'reservation' => [
               'checkIn' => $this->roomReservation->reservation->check_in,
               'checkOut' => $this->roomReservation->reservation->check_out,
            ],
            'stayDuration' => $arrivalDate->diffInDays($departureDate),
        ];
    }
}