<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class PostPurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'receipt' => ['required', 'string', 'unique:purchases,receipt'],
            'client_token' => ['required', 'string', 'exists:devices,client_token'],
        ];
    }

    public function attributes(): array
    {
        return [
            'receipt' => __('Receipt'),
            'client_token' => __('Client Token'),
        ];
    }
}
