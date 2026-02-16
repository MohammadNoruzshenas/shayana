<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;

class SettlementsRequest extends FormRequest
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
                'name' => 'required|min:1|max:195',
                'cart' => 'required|numeric',
                'amount' => 'required|numeric|min:' . Cache::get('settings')->minimum_deposit_request,
                'comments' => 'nullable|min:1|max:1500'
            ];
        } else {
            return [
                'name' => 'required',
                'cart' => 'required|numeric',

            ];
        }
    }
    public function messages(): array
    {
        return [
            'amount.min' => 'مبلغ تسویه نباید کمتر از ' . priceFormat(Cache::get('settings')->minimum_deposit_request) . ' تومان باشد',

        ];
    }
}
