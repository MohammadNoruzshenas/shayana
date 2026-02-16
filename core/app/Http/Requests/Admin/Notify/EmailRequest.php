<?php

namespace App\Http\Requests\Admin\Notify;

use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->is_admin == 1 && auth()->user()->status == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => 'required|max:120|min:2',
            'status' => 'required|numeric|in:0,1',
            'body' => 'required|max:999|min:1',
            // 'published_at' => 'nullable|numeric',
            'receive_it' => 'nullable|numeric',
            'course_id' => 'nullable|exists:courses,id',
            'type' => 'in:0,1'

        ];
    }
}
