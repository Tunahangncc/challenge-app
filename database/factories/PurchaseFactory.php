<?php

namespace Database\Factories;

use App\Models\Device\Device;
use App\Models\Device\OperatingSystem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'receipt' => Str::uuid()->toString(),
        ];
    }

    public function withDevice(): PurchaseFactory|Factory
    {
        return $this->state([
            'device_id' => Device::factory()
                ->withClientToken()
                ->hasAttached(OperatingSystem::factory()->count(1))
                ->create()
                ->id,
        ]);
    }

    public function withExpireDate(): PurchaseFactory|Factory
    {
        return $this->state([
            'expire_date' => $this->faker->dateTimeThisDecade(),
        ]);
    }

    public function receiptNumberLastDigitOddNumber(): PurchaseFactory|Factory
    {
        return $this->state([
            'receipt' => Str::uuid()->toString().$this->faker->randomElement([1, 3, 5, 7, 9]),
        ]);
    }

    public function receiptNumberLastDigitEventNumber(): PurchaseFactory|Factory
    {
        return $this->state([
            'receipt' => Str::uuid()->toString().$this->faker->randomElement([0, 2, 4, 6, 8]),
        ]);
    }
}
