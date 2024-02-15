<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRegisterRequest extends FormRequest
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
