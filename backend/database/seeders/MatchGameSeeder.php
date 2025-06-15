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
        $teams = Team::all();
        $teamCount = $teams->count();

        $rounds = $teamCount - 1;
        $half = $teamCount / 2;

        for ($i = 1; $i <= $rounds; $i++) {
            Week::firstOrCreate(['number' => $i], ['is_current' => $i === 1]);
        }

        $weeks = Week::orderBy('number')->get();

        $teamIds = $teams->pluck('id')->toArray();

        for ($round = 0; $round < $rounds; $round++) {
            for ($i = 0; $i < $half; $i++) {
                $homeIndex = ($round + $i) % ($teamCount - 1);
                $awayIndex = ($teamCount - 1 - $i + $round) % ($teamCount - 1);

                if ($i === 0) {
                    $awayIndex = $teamCount - 1;
                }

                $homeId = $teamIds[$homeIndex];
                $awayId = $teamIds[$awayIndex];

                MatchGame::create([
                    'league_id' => $league->id,
                    'week_id' => $weeks[$round]->id,
                    'home_team_id' => $homeId,
                    'away_team_id' => $awayId,
                    'played' => false
                ]);
            }
        }
    }
}
