<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreImagesRequest extends FormRequest
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
            'room_types_id' => 'required|integer',
            'image_cover_url' => 'required|string',
            'image_url_1' => 'required|string',
            'image_url_2' => 'required|string',
            'image_url_3' => 'required|string',
            'image_url_4' => 'required|string',
        ];
    }
}