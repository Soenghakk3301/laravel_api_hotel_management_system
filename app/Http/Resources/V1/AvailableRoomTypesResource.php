<?php 


namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class AvailableRoomTypesResource extends JsonResource {
   
   public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'roomType' => $this->roomtypes->name,
            'service' => new ServicesResource($this->services),
        ];
    }
}