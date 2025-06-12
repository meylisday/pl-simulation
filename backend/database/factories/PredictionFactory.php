<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\League;
use App\Models\Prediction;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Prediction>
 */
class PredictionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'league_id' => League::factory(),
            'team_id' => Team::factory(),
            'position' => $this->faker->numberBetween(1, 20),
            'probability' => $this->faker->randomFloat(3, 0, 1),
        ];
    }
}
