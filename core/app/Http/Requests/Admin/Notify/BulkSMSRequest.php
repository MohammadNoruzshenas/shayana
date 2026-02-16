<?php

namespace App\Http\Requests\Admin\Notify;

use Illuminate\Foundation\Http\FormRequest;

class BulkSMSRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'sms_type' => 'required|in:confirm,reject',
            'excel_file' => 'required|file|mimetypes:text/csv,application/csv,text/plain|max:2048',
        ];

        return $rules;
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'sms_type.required' => 'نوع پیامک الزامی است.',
            'sms_type.in' => 'نوع پیامک انتخاب شده معتبر نیست.',
            'excel_file.required' => 'فایل CSV الزامی است.',
            'excel_file.file' => 'فایل آپلود شده معتبر نیست.',
            'excel_file.mimetypes' => 'فایل باید فرمت CSV باشد.',
            'excel_file.max' => 'حجم فایل نباید بیشتر از 2 مگابایت باشد.',
            'month.required' => 'ماه الزامی است.',
            'month.integer' => 'ماه باید عدد صحیح باشد.',
            'month.between' => 'ماه باید بین 1 تا 12 باشد.',
            'year.required' => 'سال الزامی است.',
            'year.integer' => 'سال باید عدد صحیح باشد.',
            'year.min' => 'سال نباید کمتر از 1400 باشد.',
        ];
    }
} 