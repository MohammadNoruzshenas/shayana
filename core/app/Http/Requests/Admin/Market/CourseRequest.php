<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return [
                'title' => 'required|max:120|min:2',
                'priority' => 'nullable',
                'price' => 'nullable|numeric|max:99999999',
                'category_id' => 'required|exists:course_categories,id',
                'teacher_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:users,id',
                'image' => 'required|image|mimes:png,jpg,jpeg,webp',
                'video_link' => 'nullable',
                'types' => 'required|numeric|in:0,1,2',
                'course_level' => 'required|numeric|in:0,1,2,3',
                'prerequisite' => 'nullable|min:1|max:195',
                'status' => 'required|numeric|in:0,1,2,3,4',
                'get_course_option' => 'required|numeric|in:0,1',
                'spot_api_key' => 'nullable',
                'spot_course_license' => 'nullable',
                'body' => 'required|max:10000|min:5',
                'percent' => 'nullable|numeric|min:0|max:100',
                'summary' => 'required|max:1200',
                'priority' => 'nullable|numeric',
                'maximum_registration' => 'nullable|numeric'

            ];
        } else {
            return [
                'title' => 'required|max:120|min:2',
                'priority' => 'nullable',
                'price' => 'required|numeric|max:99999999',
                'category_id' => 'required|regex:/^[0-9]+$/u|exists:course_categories,id',
                'teacher_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:users,id',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,webp',
                'video_link' => 'nullable',
                'types' => 'required|numeric|in:0,1,2',
                'status' => 'required|numeric|in:0,1,2,3,4',
                'course_level' => 'required|numeric|in:0,1,2,3',
                'prerequisite' => 'nullable|min:1|max:195',
                'get_course_option' => 'required|numeric|in:0,1',
                'spot_api_key' => 'nullable',
                'spot_course_license' => 'nullable',
                'body' => 'required|max:10000|min:5',
                'percent' => 'nullable|numeric|min:0|max:100',
                'summary' => 'required|max:1200',
                'priority' => 'nullable|numeric',
                'maximum_registration' => 'nullable|numeric'

            ];
        }
    }
}
