<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomTypesResource extends JsonResource
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
            'attributes' => [
               'name' => $this->name,
               'mainDescription' => $this->main_description,
               'subDescription' => $this->sub_description,
               'bedType' => $this->bed_type,
               'price' => $this->price,
               'roomSize' => $this->room_size,
               'floor' => $this->floor,
               'numGuest' => $this->num_guest,
            ],
            'images' => ImagesResource::collection($this->whenLoaded('image')),
            'addOneServices' => AddOnServicesResource::collection($this->addOnServices),
        ];
    }
}