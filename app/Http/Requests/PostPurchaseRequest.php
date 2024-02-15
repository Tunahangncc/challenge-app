<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostPurchaseRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'receipt' => ['required', 'string', 'unique:purchases,receipt'],
            'client_token' => ['required', 'string', 'exists:devices,client_token']
        ];
    }

    public function attributes(): array
    {
        return [
            'receipt' => __('Receipt'),
            'client_token' => __('Client Token')
        ];
    }
}
