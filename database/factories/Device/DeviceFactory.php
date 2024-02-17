<?php

namespace Database\Factories\Device;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'uid' => $this->faker->unique()->uuid,
            'app_uid' => $this->faker->unique()->uuid,
        ];
    }

    public function withClientId(): DeviceFactory|Factory
    {
        return $this->state([
            'client_id' => $this->faker->unique()->uuid
        ]);
    }
}
