<?php

namespace App\Exports;

use App\Models\Device\Device;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AllDeviceWithOSInformationExport implements FromCollection, WithHeadings
{
    public function collection(): array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    {
        $reports = [];
        $devices = Device::query()
            ->with([
                'operatingSystems' => function ($builder) {
                    $builder->select([
                        'os_name',
                        'os_language',
                        'browser_name',
                        'browser_version',
                        'platform_name',
                        'platform_version',
                    ]);
                },
            ])
            ->select([
                'id',
                'uid',
            ])
            ->get();

        foreach ($devices as $device) {
            $reports[] = [
                'uid' => $device->uid,
                'os_name' => $device->operatingSystems->first()->os_name,
                'os_language' => $device->operatingSystems->first()->os_language,
                'browser_name' => $device->operatingSystems->first()->browser_name,
                'browser_version' => $device->operatingSystems->first()->browser_version,
                'platform_name' => $device->operatingSystems->first()->platform_name,
                'platform_version' => $device->operatingSystems->first()->platform_version,
            ];
        }

        return collect($reports);
    }

    public function headings(): array
    {
        return [
            'DEVICE UID',
            'OS NAME',
            'OS LANGUAGE',
            'OS BROWSER NAME',
            'OS BROWSER VERSION',
            'OS PLATFORM NAME',
            'OS PLATFORM VERSION',
        ];
    }
}
