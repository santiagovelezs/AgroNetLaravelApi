<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'data.attributes.id' => ['required', 'numeric', 'unique:admins,id', 'exists:users,id']
        ];
    }
}
