<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class TemplateSettingRequest extends FormRequest
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
        if (request()->footer_request == 'true') {
            return [
                'about_footer' => 'nullable|max:695',
                'copyright' => 'required|max:195',
                'link_instagram' => 'nullable|max:1000',
                'link_telegram' => 'nullable|max:1000',
                'footer_title_link' => 'nullable|max:195',
                'footer_title_link2' => 'nullable|max:195',
                'link_title.*' => 'nullable|max:195',
                'link_href.*' => 'nullable',
                'link_title2.*' => 'nullable|max:195',
                'link_href2.*' => 'nullable',
                'icon_html' => 'nullable',
                'description_plan_index' => 'nullable|max:3000'

            ];
        }
        return [
            'title' => 'required|min:1|max:95',
            'logo' => 'nullable|mimes:png,jpg,jpeg,webp',
            'image_auth' => 'nullable|mimes:png,jpg,jpeg',
            'meta_description' => 'required|min:1|max:9000',
            'sticky_banner' => 'nullable|max:195',
            'title_site_index' => 'nullable|max:195',
            'description_site_index' => 'nullable|max:750',
            'number_course_page' => 'numeric|max:50',
            'number_post_page' => 'numeric|max:50',
            'description_plan_index' => 'nullable|max:3000'
        ];
    }
}
