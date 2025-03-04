<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RollerCoaster>
 */
class RollerCoasterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'speed' => $this->faker->numberBetween(0, 200),
            'height' => $this->faker->numberBetween(0, 200),
            'length' => $this->faker->numberBetween(0, 2000),
            'inversions' => $this->faker->numberBetween(0, 10),
            'manufacturer_id' => \App\Models\Manufacturer::factory(),
            'theme_park_id' => \App\Models\ThemePark::factory(),
        ];
    }
}
