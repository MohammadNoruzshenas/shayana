<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;

class SeasonRequest extends FormRequest
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
            'title' => 'required|min:1|max:50',
            'number' => 'nullable|numeric',
            'parent_id' => [
                'nullable',
                'exists:seasons,id',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        // Check if trying to set self as parent (for updates)
                        if ($this->route('season') && $this->route('season')->id == $value) {
                            $fail('یک سرفصل نمی‌تواند والد خودش باشد.');
                        }
                        
                        // Check if parent belongs to the same course
                        $parent = \App\Models\Market\Season::find($value);
                        $course = $this->route('course');
                        if ($parent && $course && $parent->course_id != $course->id) {
                            $fail('سرفصل والد باید متعلق به همین دوره باشد.');
                        }
                    }
                }
            ]
        ];
    }
}
