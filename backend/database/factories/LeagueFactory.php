<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\League;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<League>
 */
class LeagueFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'League ' . $this->faker->numberBetween(1, 999),
            'season' => '2024/25',
        ];
    }
}
