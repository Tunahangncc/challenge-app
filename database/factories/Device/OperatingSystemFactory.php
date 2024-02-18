<?php

namespace Database\Factories\Device;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jenssegers\Agent\Agent;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device\OperatingSystem>
 */
class OperatingSystemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'os_name' => $this->faker->randomElement(Agent::getDesktopDevices()),
            'os_language' => $this->faker->languageCode,
            'browser_name' => $this->faker->randomElement(Agent::getBrowsers()),
            'browser_version' => $this->faker->randomElement(range(1, 10)).'.'.$this->faker->randomElement(range(0, 9)),
            'platform_name' => $this->faker->randomElement(Agent::getPlatforms()),
            'platform_version' => $this->faker->randomElement(range(1, 10)).'.'.$this->faker->randomElement(range(0, 9)),
        ];
    }
}
