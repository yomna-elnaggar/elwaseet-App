<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            
            'mobile_number'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|numeric|min:10',
            'password'=>'required|min:6',
           
        ];
    }

    public function messages(): array
    {
        return [

           // 'mobile_number.uniqueunique:users,mobile_number'=>'this phone is token ',
            'mobile_number.regex:/^([0-9\s\-\+\(\)]*)$/'=>'this unavailable phone ',
            'mobile_number.min:10:/^([0-9\s\-\+\(\)]*)$/'=>'this unavailable phone ',
        ];
    }
}
