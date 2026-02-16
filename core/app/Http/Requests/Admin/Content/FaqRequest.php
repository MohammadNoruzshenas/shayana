<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin == 1 && auth()->user()->status == 1;    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'question' => 'required|max:500',
            'answer' => 'required|max:500',
            'status' => 'required|in:0,1',
            // 'faq_type' => 'required|numeric|in:0,1',
            // 'faq_id' => 'required_if:faq_type,1|exists:courses,id'
        ];
    }
}
