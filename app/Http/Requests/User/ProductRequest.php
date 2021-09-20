<?php

namespace App\Http\Requests\User;

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
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'quantity' => ['required', 'integer'],
            'price' => ['required', 'integer'],
            'store_id' => ['required', 'integer', 'exists:stores,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id']
        ];
    }
}
