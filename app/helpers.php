<?php

function exports_url($file): string
{
    $file = ltrim((string) $file, '/');

    return route('file-export').'?'.http_build_query(['filename' => $file]);
}

function exports_path(?string $path = ''): string
{
    $base_path = storage_path('app/exports');
    @mkdir($base_path, 0777, true);

    return $base_path.($path ? '/'.$path : $path);
}
