<?php

namespace App\Jobs;

use App\Exports\AllDeviceWithOSInformationExport;
use App\Mail\AllDeviceWithOSInformationReportMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class SendAllDeviceWithOSInformationReportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private string $failAlertMail;

    public function __construct()
    {
        $this->queue = 'report';
        $this->failAlertMail = config('queue.failed.fail_alert_mail');
    }

    public function handle(): void
    {
        if ($this->failAlertMail) {
            Excel::store(new AllDeviceWithOSInformationExport(), 'exports/all_device_with_os_information_report.xlsx');

            Mail::to($this->failAlertMail)->send(new AllDeviceWithOSInformationReportMail());
        }
    }
}
