<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateImagesRequest extends FormRequest
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
            'image_cover_url' => 'sometimes|max:255',
            'image_url_1' => 'sometimes|max:255',
            'image_url_2' => 'sometimes|max:255',
            'image_url_3' => 'sometimes|max:255',
            'image_url_4' => 'sometimes|max:255',
        ];
    }
}