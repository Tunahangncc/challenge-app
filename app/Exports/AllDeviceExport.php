<?php

namespace App\Exports;

use App\Models\Device\Device;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AllDeviceExport implements FromCollection, WithHeadings
{
    public function collection(): \Illuminate\Support\Collection
    {
        return Device::query()
            ->select([
                'uid',
                DB::raw('COUNT(*) as number_of_app'),
            ])
            ->groupBy('uid')
            ->get();
    }

    public function headings(): array
    {
        return [
            'DEVICE UID',
            'NUMBER OF REGISTERED DEVICES',
        ];
    }
}
