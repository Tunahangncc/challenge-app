<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetCheckSubscriptionRequest;
use App\Http\Requests\PostPurchaseRequest;
use App\Http\Requests\PostRegisterRequest;
use App\Models\Device\Device;
use App\Models\Device\OperatingSystem;
use App\Models\Purchase;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Ramsey\Uuid\Uuid;

class APIController extends Controller
{
    public function postRegister(PostRegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        DB::beginTransaction();

        // If the device and application are not found, they are created
        $device = Device::query()
            ->where('uid', $data['uid'])
            ->where('app_uid', $data['app_uid'])
            ->first();

        if ($device) {
            return response()->json([
                'status' => true,
                'client_token' => $device->client_token,
            ]);
        }

        $data['client_token'] = Uuid::uuid1()->toString();
        $device = Device::query()->create($data);

        // OS information is saved with the device;
        $this->setOperatingSystemData($device);

        DB::commit();

        return response()->json([
            'status' => true,
            'client_token' => $device->client_token,
        ]);
    }

    public function postPurchase(PostPurchaseRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        $device = Device::whereClientToken($data['client_token'])->first();

        $receiptLastNumber = substr($data['receipt'], -1);
        if ((int) $receiptLastNumber % 2 == 0) {
            return response()->json([
                'status' => false,
                'expire_date' => null,
            ]);
        }

        $purchase = Purchase::query()->create([
            'receipt' => $data['receipt'],
            'device_id' => $device->id,
            'expire_date' => now(),
        ]);

        return response()->json([
            'status' => true,
            'expire_date' => $purchase->expire_date,
        ]);
    }

    public function postCheckSubscription(GetCheckSubscriptionRequest $request)
    {
        $data = $request->validated();

        $device = Device::whereClientToken($data['client_token'])->first();

        return response()->json([
            'status' => true,
            'subscriptions' => $device->subscription
        ]);
    }

    private function setOperatingSystemData(Device $device): void
    {
        $agent = new Agent();

        $osData = [
            'os_name' => $agent->device(),
            'os_language' => implode(',', $agent->languages()),
            'browser_name' => $agent->browser(),
            'browser_version' => $agent->version($agent->browser()),
            'platform_name' => $agent->platform(),
            'platform_version' => $agent->version($agent->platform()),
        ];

        $isSystemRegistered = $device->operatingSystems
            ->where('os_name', $osData['os_name'])
            ->where('browser_name', $osData['browser_name'])
            ->where('browser_version', $osData['browser_version'])
            ->where('platform_name', $osData['platform_name'])
            ->where('platform_version', $osData['platform_version'])
            ->first();

        if ($isSystemRegistered) {
            return;
        }

        $operatingSystem = OperatingSystem::query()->create($osData);
        $device->operatingSystems()->attach($operatingSystem->id);
    }
}
