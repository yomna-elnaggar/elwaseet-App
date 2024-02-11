<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'=>'required|max:50',
            'mobile_number'=>'required|unique:users,mobile_number|regex:/^([0-9\s\-\+\(\)]*)$/|numeric|min:10',
            'country_code'=>'required',
            'email'=> 'required|email',
            'password'=>'required|min:6',
           
        ];
    }

    public function messages(): array
    {
        return [

            'mobile_number.uniqueunique:users,phone'=>'this mobile number is token ',
           
            'mobile_number.regex:/^([0-9\s\-\+\(\)]*)$/'=>'this unavailable mobile number ',
            'mobile_number.min:10'=>'this unavailable mobile number ',
        ];
    }
}
