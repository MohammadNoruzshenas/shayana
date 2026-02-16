<?php

namespace App\Http\Requests\Auth\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|max:195|unique:users,email',
            'password' => ['required', 'max:195', 'confirmed', Password::min(8)],
            'mobile' => 'required|numeric|unique:users,mobile',
            'rules' => 'required|accepted',
            'g-recaptcha-response' => 'recaptcha'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'rules.required' => 'باید قوانین و مقررات سایت را بپذیرید',
            'rules.accepted' => 'باید قوانین و مقررات سایت را بپذیرید',
        ];
    }
}
