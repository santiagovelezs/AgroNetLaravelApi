<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'data.attributes.producer_id' => ['required', 'exists:producers,id', 'unique:shops,producer_id'],
            'data.attributes.whatsapp' => ['required', 'string', 'max:255'],
            'data.attributes.phone' => ['required', 'string', 'max:255'],
            'data.attributes.email' => ['required', 'string', 'email', 'max:255'],
            'data.attributes.addr_id' => ['required', 'exists:addrs,id'],
            'data.attributes.price_per_km' => ['required', 'numeric'],
            'data.attributes.max_shipping_distance' => ['required', 'numeric']
        ];
    }
}
