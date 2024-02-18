<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class PostRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uid' => ['required', 'string'],
            'app_uid' => ['required', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'uid' => __('Device UID'),
            'app_uid' => __('APP UID'),
        ];
    }
}
