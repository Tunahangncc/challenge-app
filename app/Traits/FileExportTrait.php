<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

trait FileExportTrait
{
    public function exportFile(string $filename): BinaryFileResponse
    {
        $filename = basename($filename);

        if (! $filename) {
            abort(404);
        }

        $filePath = exports_path($filename);

        if (! File::exists($filePath)) {
            abort(404);
        }

        return Response::download($filePath, $filename);
    }
}
