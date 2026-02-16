<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;
use Mockery\Generator\Method;

class LessionRequest extends FormRequest
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
                'title' => 'required|min:1|max:50',
                'number' => 'nullable|numeric',
                'time' => 'required|numeric|max:200',
                'season_id' => 'required|exists:seasons,id',
                'is_free' => 'numeric|in:0,1',
                'link' => 'nullable',
                'file_link' => 'nullable',
                'body' => 'nullable',
                'installment_show_count' => 'required|numeric|min:1'

            ];
        }else{
            return[
                'title' => 'required|min:1|max:50',
                'number' => 'nullable',
                'time' => 'required|max:200',
                'season_id' => 'required|exists:seasons,id',
                'is_free' => 'numeric|in:0,1',
                'link' => 'nullable',
                'file_link' => 'nullable',
                'body' => 'nullable',
                'installment_show_count' => 'required|numeric|min:1'
            ];

        }

    }
}
