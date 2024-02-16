<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'integer|exists:brands,id',
            'name' => 'required|string',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg',
            'slug' => 'required|unique:products,slug',
            'price' => 'required|integer',
            'description' => 'required|string',
            'quantity' => 'required|integer'
        ];
    }
}
