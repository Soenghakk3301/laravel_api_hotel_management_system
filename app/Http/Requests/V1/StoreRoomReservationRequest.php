<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    { 
      return [
         'check_in' => 'required|date',
         'check_out' => 'required|date|after:check_in_date',
         'guest_name' => 'required|string',
         'guest_email' => 'required|email',
         'guest_phone_number' => 'required|string',
         'is_male' => 'required|boolean',
         'room_bookings' => 'required|array',
         'room_bookings.*.room_id' => 'required|integer|exists:rooms,id',
     ];
    }
}