<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'site_repair' => 'in:on,off',
            'can_send_ticket' => 'in:on,off',
            'commentable' => 'in:on,off',
            'comment_default_approved' => 'in:on,off',
            'stop_selling' => 'in:on,off',
            'can_register_user' => 'in:on,off',
            'show_resources_server' => 'in:on,off',
            'can_request_settlements' => 'in:on,off',
            'settlement_pay_time' => 'required|numeric|max:60',
            'minimum_deposit_request' => 'required|numeric',
            'chat_online' => 'in:on,off',
            'defult_uploader_private' => 'in:local,s3',
            'defult_uploader_public' => 'in:local',
            'account_confirmation' => 'in:on,off',
            'recaptcha' => 'in:on,off',
            'method_login_register' => 'required|numeric|in:0,1,2',
            'rules' => 'nullable|string'
        ];
    }
}
