<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ImagesResource extends JsonResource
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
            'attributed' => [
               'roomTypesId' => $this->room_types_id,
               'imageCoverUrl' => $this->image_cover_url,
               'imageUrl1' => $this->image_url_1,
               'imageUrl2' => $this->image_url_2,
               'imageUrl3' => $this->image_url_3,
               'imageUrl4' => $this->image_url_4,
            ],
            'roomtype' => $this->roomtype,
        ];
    }
}