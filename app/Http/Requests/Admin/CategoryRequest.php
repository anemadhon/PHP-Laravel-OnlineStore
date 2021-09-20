<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $rules = Category::VALIDATION_RULES;
        
        if ($this->getMethod() === 'POST') return $rules += ['icon' => ['required', 'file', 'image', 'mimes:svg']];

        return $rules;
    }
}
