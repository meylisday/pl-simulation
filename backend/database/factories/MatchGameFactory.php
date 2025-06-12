<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\League;
use App\Models\MatchGame;
use App\Models\Team;
use App\Models\Week;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MatchGame>
 */
class MatchGameFactory extends Factory
{
    public function definition(): array
    {
        return [
            'league_id' => League::factory(),
            'week_id' => Week::factory(),
            'home_team_id' => Team::factory(),
            'away_team_id' => Team::factory(),
            'home_goals' => null,
            'away_goals' => null,
            'played' => false,
        ];
    }
}
