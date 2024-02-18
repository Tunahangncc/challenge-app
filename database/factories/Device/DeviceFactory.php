<?php

namespace Database\Factories\Device;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uid' => Str::uuid()->toString(),
            'app_uid' => Str::uuid()->toString(),
        ];
    }

    public function withClientToken(): DeviceFactory|Factory
    {
        return $this->state([
            'client_token' => Str::uuid()->toString(),
        ]);
    }
}
