<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Foundation\Http\FormRequest;

class PodcastRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->isMethod('post')){
            return [
                'title' => 'required|max:120|min:2',
                'summary' => 'required|max:1950|min:5',
                'category_id' => 'required|min:1|max:100000000|exists:podcast_categories,id',
                'podcaster_id' => 'nullable|exists:users,id',
                'image' => 'required|image|mimes:png,jpg,jpeg,gif,webp',
                'status' => 'nullable|numeric|in:0,1',
                'is_vip' => 'nullable|numeric|in:0,1',
                'body' => 'required|max:10000000|min:5',
                'published_at' => 'required|numeric',
                'voice' => 'required'
            ];
        }
        else{
            return [
                'title' => 'required|max:120|min:2',
                'summary' => 'required|max:1950|min:5',
                'category_id' => 'required|min:1|max:100000000|exists:podcast_categories,id',
                'podcaster_id' => 'nullable|exists:users,id',
                'image' => 'image|mimes:png,jpg,jpeg,gif,webp',
                'status' => 'nullable|numeric|in:0,1',
                'is_vip' => 'nullable|numeric|in:0,1',
                'body' => 'required|max:10000000|min:5',
                'published_at' => 'required|numeric',
                'voice' => 'required'
            ];
        }
    }

}
