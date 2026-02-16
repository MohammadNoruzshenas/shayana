<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;

class CourseCategoriesRequest extends FormRequest
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
        return [
            'title' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'parent_id' => 'nullable|min:1|max:100000000|regex:/^[0-9]+$/u|exists:course_categories,id',
            'status' => 'required|numeric|in:0,1',
            'svg_code' => 'nullable',
            'meta_description' => 'required|max:3500',


            // 'show_in_menu' => 'required|numeric|in:0,1',
        ];

    }
}
