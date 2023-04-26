<?php

namespace App\Http\Resources\V1;

use App\Models\RoomTypes;
use Illuminate\Http\Resources\Json\JsonResource;

class AddOnServicesResource extends JsonResource
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
            'roomType' => $this->roomtypes->name,
            'service' => new ServicesResource($this->services),
        ];
    }
}