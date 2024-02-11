<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name'=>'required|max:255',
            'mobile_number'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|numeric|min:10',
            'category_id'=>'exists:categories,id',
            'subcategory_id'=>'exists:sub_categories,id',
            'gender'=>'sometimes',
            'government_id'=>'exists:governments,id',
            'state_id'=>'exists:states,id',
            'type'=>'sometimes',
            'color'=>'sometimes',
            'size'=>'sometimes',
            'new_or_used'=>'sometimes',
            'sale_or_rent'=>'sometimes',
            'Furnished_or_not'=>'sometimes',
            'description'=>'nullable',
            'images.*'=>['image','mimes:jpg,webp,png,jpeg','max:2048'],
            'selling_price'=>'sometimes',
            'payment_way'=>'sometimes',
            'Space'=>'sometimes',
            'Luxuries'=>'sometimes',
            'bedrooms_number'=>'sometimes',
            'bathrooms_number'=>'sometimes',
            'floors_number'=>'sometimes',
            'fuel_type'=>'sometimes',
            'car_transmission'=>'sometimes',
            'car_body_type'=>'sometimes',
            'car_engine'=>'sometimes',
            'storage_capacity'=>'sometimes',
            'views'=>'sometimes',
            'favorite'=>'sometimes',
            'status'=>'sometimes',
        ];
    }
}
