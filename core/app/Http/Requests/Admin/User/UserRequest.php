<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin == 1 && auth()->user()->status == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        if(request()->method() == 'POST')
        {
            return [
                'first_name' => 'required|min:1|max:50',
                'last_name' => 'required|min:1|max:50',
                'username' => 'nullable|min:1|max:50|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'mobile' => 'required|numeric',
                'is_admin' => 'required|in:0,1',
                'password' => 'required|max:64',
                'status' => 'required|in:0,1'
            ];
        }else{
            return [
                'first_name' => 'required|min:1|max:50',
                'last_name' => 'required|min:1|max:50',
                'username' => 'nullable|min:1|max:50|unique:users,username,'. request()->route('user')->id,
                'email' => 'required|email|unique:users,email,'. request()->route('user')->id,
                'mobile' => 'required|numeric',
                'password' => 'nullable|max:64',
                'cart' => 'nullable|max:16|min:16',
                'shaba' => 'nullable|max:24|min:24',
                'bio' => 'nullable|min:1|max:3000',
                'instagram' => 'nullable|min:1|max:195',
                'telegram' => 'nullable|min:1|max:195',
                'image' => 'nullable|mimes:png,jpg,jpeg|max:300',
                'headline' => 'nullable|min:1|max:195',
                'parent_name' => 'nullable|min:1|max:100',
                'age' => 'nullable|integer|min:1|max:150',
                'gender' => 'nullable|in:male,female',
                'birth' => 'nullable|date|before:today',

            ];
        }

    }
}
