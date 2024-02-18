<?php

namespace App\Http\Controllers;

use App\Jobs\SendAllDeviceReportJob;
use App\Jobs\SendAllDeviceWithOSInformationReportJob;
use App\Traits\FileExportTrait;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    use FileExportTrait;

    public function getAllDevice(): JsonResponse
    {
        SendAllDeviceReportJob::dispatch();

        return $this->responseJson([
            'status' => true,
            'message' => 'Check your mail',
        ]);
    }

    public function getAllDeviceWithOsInformation(): JsonResponse
    {
        SendAllDeviceWithOSInformationReportJob::dispatchSync();

        return $this->responseJson([
            'status' => true,
            'message' => 'Check your mail',
        ]);
    }
}
