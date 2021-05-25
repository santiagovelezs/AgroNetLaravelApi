<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [

            'data' => ['required', 'array'],
            'data.type' => ['required'],
            'data.attributes' => ['required', 'array'],
            'data.attributes.producer_id' => ['required', 'integer','exists:producers,id'],
            'data.attributes.category_id' => ['nullable', 'integer', 'exists:categorys,id'],
            'data.attributes.image_path' => ['nullable','string'],
            'data.attributes.name' => ['required','string'],
            'data.attributes.description' => ['required', 'string', 'max:200'],
            'data.attributes.measurement' => ['required', 'integer'],
            'data.attributes.price' => ['required', 'numeric'] 
        ];
    }
}

