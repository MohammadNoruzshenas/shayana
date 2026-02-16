<?php

namespace App\Http\Requests\Admin\Notify;

use Illuminate\Foundation\Http\FormRequest;

class EmailFileRequest extends FormRequest
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
        if($this->isMethod('post')){
            return [
                'file' => 'required|mimes:png,jpg,jpeg,gif,zip,pdf,docx,doc,webp',
                'status' => 'required|numeric|in:0,1',
            ];
        }
        else{
            return [
                'file' => 'mimes:png,jpg,jpeg,gif,zip,pdf,docx,doc,webp',
                'status' => 'required|numeric|in:0,1',
            ];
        }
    }
}
