<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TDSDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->faker->randomFloat(2, 800, 1400), // Random values between 800-1400
            'sensor_id' => 'tds_sensor_1',
            'measured_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
