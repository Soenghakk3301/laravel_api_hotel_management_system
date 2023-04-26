<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomTypesRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'main_description' => 'required|string|max:255',
            'sub_description' => 'required|string|max:255',
            'bed_type' => 'required|string|max:255',
            'price' => 'required',
            'room_size' => 'required',
            'floor' => 'required|string',
            'num_guest' => 'required|integer',
        ];
    }
}