<?php

namespace App\Http\Requests\Customer\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ProfileUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|min:1|max:50',
            'last_name' => 'required|min:1|max:50',
            'mobile' => 'nullable|numeric',
            'email' => 'nullable|max:195',
            'password' => ['nullable', 'max:195', 'confirmed', Password::min(8)],
            'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:300'
        ];
    }
}
