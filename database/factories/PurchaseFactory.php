<?php

namespace Database\Factories;

use App\Models\Device\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'receipt' => $this->faker->unique()->uuid,
        ];
    }

    public function withDevice(): PurchaseFactory|Factory
    {
        return $this->state([
            'device_id' => Device::factory()->create([
                'client_token' => $this->faker->unique()->uuid
            ])->id
        ]);
    }

    public function withExpireDate(): PurchaseFactory|Factory
    {
        return $this->state([
            'expire_date' => now()->format('Y-m-d')
        ]);
    }

    public function receiptNumberLastDigitOddNumber(): PurchaseFactory|Factory
    {
        return $this->state([
            'receipt' => $this->faker->unique()->uuid . $this->faker->randomElement([1, 3, 5, 7, 9])
        ]);
    }

    public function receiptNumberLastDigitEventNumber(): PurchaseFactory|Factory
    {
        return $this->state([
            'receipt' => $this->faker->unique()->uuid . $this->faker->randomElement([0, 2, 4, 6, 8])
        ]);
    }
}
