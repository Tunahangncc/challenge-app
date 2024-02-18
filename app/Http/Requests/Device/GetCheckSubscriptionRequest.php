<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class GetCheckSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_token' => ['required', 'string', 'exists:devices,client_token'],
        ];
    }

    public function attributes(): array
    {
        return [
            'client_token' => __('Client Token'),
        ];
    }
}
