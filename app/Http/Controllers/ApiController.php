<?php

namespace App\Http\Controllers;

use App\Traits\FileExportTrait;

class ApiController extends Controller
{
    use FileExportTrait;

    public function getExportFile(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return $this->exportFile(\Illuminate\Support\Facades\Request::input('filename'));
    }
}
