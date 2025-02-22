<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    /*обновление продукта*/
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:6|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'discount' => 'required|numeric|min:0|max:100',
        ];
    }
}
