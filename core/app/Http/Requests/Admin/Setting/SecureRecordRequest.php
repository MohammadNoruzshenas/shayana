<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SecureRecordRequest extends FormRequest
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
        return [
            'recaptcha_site_key' => 'nullable|max:255',
            'recaptcha_secret_key' => 'nullable|max:195',

            'spot_api_key' => 'nullable|max:195',
            'mail_transport' => 'nullable|max:195',
            'mail_host' => 'nullable|max:195',
            'mail_port' => 'nullable|max:195',
            'mail_username' => 'nullable|max:195',
            'mail_password' => 'nullable|max:195',
            'mail_encyption' => 'nullable|max:195',
            'mail_from_address' => 'nullable|max:195',
            'mail_from_name' => 'nullable|max:195',
            'chat_online_key' => 'nullable|max:512',
            'site_repair_key' => 'nullable|max:195',
            's3_key' => 'nullable|max:195',
            's3_secret' => 'nullable|max:195',
            's3_bucket' => 'nullable|max:195',
            's3_endpoint' => 'nullable|max:195',
            'ftp_host' => 'nullable|max:195',
            'ftp_username' => 'nullable|max:195',
            'ftp_password' => 'nullable|max:195',
            'ftp_password' => 'nullable|max:195',
            'site_url' => 'nullable|max:195',
        ];
    }
}
