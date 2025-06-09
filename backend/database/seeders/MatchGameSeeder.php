<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\League;
use App\Models\MatchGame;
use App\Models\Team;
use App\Models\Week;
use Illuminate\Database\Seeder;

class MatchGameSeeder extends Seeder
{
    public function run(): void
    {
        $league = League::first();
        $weeks = Week::all();
        $teams = Team::all();

        $teamPairs = $teams->crossJoin($teams)
            ->filter(fn ($pair) => $pair[0]->id !== $pair[1]->id)
            ->values()
            ->unique(function ($pair) {
                return collect([$pair[0]->id, $pair[1]->id])->sort()->join('-');
            });

        $weekIndex = 0;

        foreach ($teamPairs as $pair) {
            MatchGame::create([
                'league_id' => $league->id,
                'week_id' => $weeks[$weekIndex % $weeks->count()]->id,
                'home_team_id' => $pair[0]->id,
                'away_team_id' => $pair[1]->id,
                'played' => false
            ]);

            $weekIndex++;
        }
    }
}
