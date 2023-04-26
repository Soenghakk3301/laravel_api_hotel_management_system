<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomTypesRequest extends FormRequest
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
            'name' => 'sometimes|max:255',
            'main_description' => 'sometimes',
            'sub_description' => 'sometimes',
            'bed_types' => 'sometimes',
            'price' => 'sometimes|numeric|min:0',
            'floor' => 'sometimes|max:255',
            'num_guest' => 'sometimes|numeric|min:0',
        ];
    }
}