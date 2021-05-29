<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
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
            'data.attributes.question_id' => ['required', 'integer','exists:questions,id'],
            'data.attributes.answer' => ['required', 'string', 'max:400']
        ];
    }
}

