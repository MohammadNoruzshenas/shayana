<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Foundation\Http\FormRequest;

class AdsRequest extends FormRequest
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
        if($this->isMethod('post'))
        {
            return [
                'title' => 'required|max:120|min:1',
                'link' => 'required|max:500|min:1',
                'banner' => 'required|image|mimes:png,jpg,jpeg,gif,webp',
                'position' => 'required|numeric|in:0,1,2',
                'start_at' => 'required',
                'enddate_at' => 'required'

            ];
        }else{
            return[
                'title' => 'required|max:120|min:1',
                'link' => 'required|max:500|min:1',
                'banner' => 'nullable|image|mimes:png,jpg,jpeg,gif,webp',
                'position' => 'required|numeric|in:0,1,2',
                'start_at' => 'required',
                'enddate_at' => 'required'
            ];
        }
}
}
