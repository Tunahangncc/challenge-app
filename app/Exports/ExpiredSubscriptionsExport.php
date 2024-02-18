<?php

namespace App\Exports;

use App\Models\Purchase;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ExpiredSubscriptionsExport implements FromCollection, WithStrictNullComparison
{
    public function collection(): Collection
    {
        return Purchase::query()->expiredSubscriptions()->get();
    }
}
