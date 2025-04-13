<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
     */
    public function rules(): array
    {
        $isUpdate = $this->method() === 'PUT' || $this->method() === 'PATCH';
        $productId = $this->route('product')?->id ?? null;

        return [
            'name'        => $isUpdate ? 'sometimes|string|max:255' : 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => $isUpdate ? 'sometimes|numeric|min:1' : 'required|numeric|min:1',
            'stock'       => $isUpdate ? 'sometimes|numeric|min:1' : 'required|numeric|min:1',
            'images'      => 'nullable|array',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
            'sku'         => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:100',
                'unique:products,sku,' . $productId,
            ],
        ];
    }    
    
    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'name.required'        => 'The product name is required.',
            'name.string'          => 'The product name must be a string.',
            'name.max'             => 'The product name may not be greater than 255 characters.',

            'description.string'   => 'The description must be a string.',

            'price.required'       => 'The price is required.',
            'price.numeric'        => 'The price must be a number.',
            'price.min'            => 'The price must be at least 1.',

            'images.*.image'       => 'Each uploaded file must be an image.',
            'images.*.mimes'       => 'Images must be of type: jpeg, png, jpg, gif.',
            'images.*.max'         => 'Each image must not exceed 2MB.',

            'stock.required'       => 'The stock is required.',
            'stock.numeric'        => 'The stock must be a numeric.',
            'stock.min'            => 'The stock must be at least 1.',

            'sku.required'         => 'The SKU is required.',
            'sku.string'           => 'The SKU must be a string.',
            'sku.max'              => 'The SKU may not be greater than 100 characters.',
            'sku.unique'           => 'The SKU must be unique.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }
}
