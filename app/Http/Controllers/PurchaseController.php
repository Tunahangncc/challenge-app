<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase\PostPurchaseRecoveryExpireDateRequest;
use App\Http\Requests\Purchase\PostPurchaseRequest;
use App\Models\Device\Device;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class PurchaseController extends Controller
{
    public function postPurchase(PostPurchaseRequest $request): JsonResponse
    {
        $data = $request->validated();

        $device = Device::whereClientToken($data['client_token'])->first();

        // If the last digit of the sent receipt is not an odd number, an error is given.
        $receiptLastNumber = str($data['receipt'])->take(-1)->toString();
        if ((int) $receiptLastNumber % 2 == 0) {
            return response()->json([
                'status' => false,
                'expire_date' => null,
            ]);
        }

        // If there is no purchase, a new purchase will be created
        $purchase = Purchase::query()->create([
            'receipt' => $data['receipt'],
            'device_id' => $device->id,
            'expire_date' => now()->format('Y-m-d'),
        ]);

        return response()->json([
            'status' => true,
            'expire_date' => $purchase->expire_date,
        ]);
    }

    public function postRecoveryPurchase(PostPurchaseRecoveryExpireDateRequest $request): JsonResponse
    {
        $data = $request->validated();

        $purchase = Purchase::whereReceipt($data['receipt'])->first();

        $newExpireDate = Carbon::parse($purchase->expire_date)->addMonth()->format('Y-m-d');
        $purchase->update([
            'expire_date' => $newExpireDate,
        ]);

        return response()->json([
            'status' => true,
            'expire_date' => $purchase->expire_date,
        ]);
    }
}
