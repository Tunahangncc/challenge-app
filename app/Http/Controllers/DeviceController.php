<?php

namespace App\Http\Controllers;

use App\Http\Requests\Device\GetCheckSubscriptionRequest;
use App\Http\Requests\Device\PostChangeLanguageRequest;
use App\Http\Requests\Device\PostRegisterRequest;
use App\Http\Resources\CheckSubscriptionResources;
use App\Models\Device\Device;
use App\Models\Device\OperatingSystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Ramsey\Uuid\Uuid;

class DeviceController extends Controller
{
    public function postChangeLanguage(PostChangeLanguageRequest $request): JsonResponse
    {
        $data = $request->validated();

        $device = Device::whereClientToken($data['client_token'])->first();
        $device->operatingSystems->first()->update([
            'os_language' => $data['language'],
        ]);

        return response()->json([
            'status' => true,
            'messages' => __('Device language changed to :lang', ['lang' => $data['language']]),
        ]);
    }

    public function postRegister(PostRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        DB::beginTransaction();

        $device = Device::query()
            ->where('uid', $data['uid'])
            ->where('app_uid', $data['app_uid'])
            ->first();

        if ($device) {
            return $this->responseJson([
                'status' => true,
                'client_token' => $device->client_token,
                'message' => __('The device is already registered'),
            ]);
        }

        $data['client_token'] = Uuid::uuid1()->toString();
        $device = Device::query()->create($data);

        // Set operating system data
        $this->setOsData($device);

        DB::commit();

        return response()->json([
            'status' => true,
            'client_token' => $device->client_token,
            'message' => __('Successfully Registered'),
        ]);
    }

    public function getCheckSubscription(GetCheckSubscriptionRequest $request): JsonResponse
    {
        $data = $request->validated();

        $device = Device::whereClientToken($data['client_token'])->first();

        return response()->json([
            'status' => true,
            'subscription' => isset($device->subscription) ? new CheckSubscriptionResources($device->subscription) : null,
        ]);
    }

    // region Private Functions
    private function setOsData(Device $device): void
    {
        $agent = new Agent();

        $osData = [
            'os_name' => $agent->device(),
            'os_language' => $agent->languages()[0] ?? null,
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

    // endregion
}
