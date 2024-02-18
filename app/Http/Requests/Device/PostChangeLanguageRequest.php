<?php

namespace App\Http\Requests\Device;

use App\Enums\SupportedLanguagesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostChangeLanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $supportedLanguage = SupportedLanguagesEnum::getAllValues();

        return [
            'client_token' => ['required', 'string', 'exists:devices,client_token'],
            'language' => ['required', 'string', Rule::in($supportedLanguage)],
        ];
    }

    public function attributes(): array
    {
        return [
            'client_token' => __('Client Token'),
            'language' => __('Language'),
        ];
    }
}
