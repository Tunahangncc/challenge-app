<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckSubscriptionResources extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'receipt' => $this->receipt,
            'expire_date' => $this->expire_date,
        ];
    }
}
