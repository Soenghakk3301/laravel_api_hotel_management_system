<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
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
         'userTypesId' => $this->user_types_id,
         'name' => $this->name,
         'email' => $this->email,
         'gender' => $this->gender,
         'phoneNumber' => $this->phone_number,
        ];
    }
}