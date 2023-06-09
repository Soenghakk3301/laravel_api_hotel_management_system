<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

use function PHPSTORM_META\map;

class RoomResource extends JsonResource
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
            'id' => (string)$this->id,
            'roomNo' => $this->room_no,
            'isAvalible' => $this->is_available,
            'roomtype' => [
               'roomTypesId' => $this->room_types_id,
               'name' => $this->name,
               // 'mainDescription' => $this->main_description,
               // 'subDescription' => $this->sub_description,
               'bedType' => $this->bed_type,
               'price' => $this->price,
               'roomSize' => $this->room_size,
               'floor' => $this->floor,
               'numGuest' => $this->num_guest,
            ],
        ];
    }
}