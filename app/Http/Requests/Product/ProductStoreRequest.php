<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'user_id'=>'nullable',
            'subcategory_id'=>'exists:sub_categories,id',
            'gender'=>'sometimes',
            'government_id'=>'exists:governments,id',
            'state_id'=>'exists:states,id',
            'sale_or_rent'=>'sometimes',
            'description'=>'nullable',
            'images.*'=>['image','mimes:jpg,webp,png,jpeg','max:2048'],
            'selling_price'=>'sometimes',
            'payment_way'=>'sometimes',
            'views'=>'sometimes',
            'favorite'=>'sometimes',
            'status'=>'sometimes',
            
        ];
    }
}
