<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Week;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Week>
 */
class WeekFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => $this->faker->unique()->numberBetween(1, 38),
            'is_current' => false,
        ];
    }
}
