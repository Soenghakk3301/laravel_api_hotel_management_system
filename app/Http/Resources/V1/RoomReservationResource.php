<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'reservationId' => $this->reservation_id,
            'roomId' => $this->room_id,
            'reservation' => [
               'id' => $this->reservation->guest->id,
               'date' => [
                  'checkIn' => $this->reservation->check_in,
                  'checkOut' => $this->reservation->check_out,
               ],
               'guest' => [
                  'name' => $this->reservation->guest->name,
                  'isMale' => $this->reservation->guest->is_male,
                  'email' => $this->reservation->guest->email,
                  'phoneNumber' => $this->reservation->guest->phon_number,
               ],
            ],
            'room' => [
               'id' => $this->id,
               'roomType' => [
                  $this->room->roomtype,
               ],
               'roomNo' => $this->room->room_no,
            ],
        ];
    }
}