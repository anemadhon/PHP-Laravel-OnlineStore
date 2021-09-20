<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PersonalInfoRequest extends FormRequest
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
            'address_one' => ['required', 'string'],
            'address_two' => ['string'],
            'provincy' => ['required', 'string'],
            'regency' => ['required', 'string'],
            'zip_code' => ['required', 'integer'],
            'country' => ['required', 'string']
        ];
    }
}
