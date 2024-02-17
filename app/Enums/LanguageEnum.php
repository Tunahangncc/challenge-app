<?php

namespace App\Enums;

enum LanguageEnum: string
{
    case TR = 'tr';
    case EN = 'en';

    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
