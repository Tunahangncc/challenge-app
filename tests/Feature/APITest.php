<?php

namespace Tests\Feature;

use App\Models\Device\Device;
use App\Models\Device\OperatingSystem;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Jenssegers\Agent\Agent;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class APITest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Event::fake();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf8',
        ]);
    }

    public function test_create_register()
    {
        $deviceAttributes = Device::factory()->make()->getAttributes();

        $response = $this->post(route('api.register'), $deviceAttributes);
        $response->assertSuccessful();

        // Check Data
        $this->assertDatabaseHas('devices', [
            'client_token' => $response->json('client_token')
        ]);
    }

    public function test_old_register()
    {
        $device = Device::factory()->create([
            'client_token' => Uuid::uuid1()->toString()
        ]);

        $deviceAttributes = Device::factory()->make([
            'uid' => $device->uid,
            'app_uid' => $device->app_uid
        ])->getAttributes();

        // Create new device
        $response = $this->post(route('api.register'), $deviceAttributes);
        $response->assertSuccessful();

        // Check Data
        $this->assertDatabaseHas('devices', [
            'client_token' => $response->json('client_token')
        ]);

        // Check response message
        $response->assertJson([
            'status' => true,
            'message' => __('The device is already registered')
        ]);
    }

    public function test_register_validations()
    {
        // Required validation
        $response = $this->post(route('api.register'), []);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'uid',
                'app_uid'
            ]);

        // Custom validation
        $device = Device::factory()->create(['client_token' => Uuid::uuid1()->toString()]);
        $deviceAttributes = Device::factory()->make([
            'uid' => $device->uid,
            'app_uid' => $device->app_uid,
        ])->getAttributes();
        $response = $this->post(route('api.register'), $deviceAttributes);
        $response->assertJson([
            'message' => __('The device is already registered'),
        ]);
    }



    public function test_create_purchase()
    {
        $deviceAttributes = Device::factory()->make()->getAttributes();

        // Register new device
        $response = $this->post(route('api.register'), $deviceAttributes);
        $response->assertSuccessful();

        // Make a purchase with a new device
        $purchaseAttributes = Purchase::factory()
            ->receiptNumberLastDigitOddNumber()
            ->make([
                'client_token' => $response->json('client_token'),
            ])->getAttributes();
        $response = $this->post(route('api.purchase'), $purchaseAttributes);
        $response->assertSuccessful();

        // Find purchase
        $purchase = Purchase::whereReceipt($purchaseAttributes['receipt'])->first();

        // Check Data
        $this->assertDatabaseHas('purchases', [
            'receipt' => $purchase->receipt,
            'expire_date' => $response->json('expire_date'),
        ]);
    }

    public function test_purchase_validations()
    {
        // Required validation
        $response = $this->post(route('api.purchase'), []);
        $response->assertStatus(422)->assertJsonValidationErrors([
            'receipt',
            'client_token'
        ]);

        // Custom validation
        $device = Device::factory()->create(['client_token' => Uuid::uuid1()->toString()]);

        $purchaseAttributes = Purchase::factory()->receiptNumberLastDigitEventNumber()->make([
            'client_token' => $device->client_token
        ])->getAttributes();

        $response = $this->post(route('api.purchase'), $purchaseAttributes);
        $response->assertJson([
            'status' => false,
            'expire_date' => null
        ]);
    }

    public function test_check_subscription()
    {
        $device = Device::factory()->create([
            'client_token' => Uuid::uuid1()->toString()
        ]);

        // Check Device Data
        $this->assertDatabaseHas('devices', [
            'client_token' => $device->client_token
        ]);

        // Create Purchase
        $purchaseAttributes = Purchase::factory()
            ->receiptNumberLastDigitOddNumber()
            ->make([
                'client_token' => $device->client_token
            ])
            ->getAttributes();
        $response = $this->post(route('api.purchase'), $purchaseAttributes);
        $response->assertSuccessful();

        // Check Purchase Data
        $this->assertDatabaseHas('purchases', [
            'device_id' => $device->id,
            'expire_date' => $response->json('expire_date'),
            'receipt' => $purchaseAttributes['receipt']
        ]);

        // Check subscription
        $response = $this->post(route('api.check-subscription'), [
            'client_token' => $device->client_token
        ]);
        $response->assertSuccessful();
    }
}
