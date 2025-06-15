<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MatchGame;
use App\Models\Team;

class StandingsService
{
    public function getStandings(): array
    {
        $teams = Team::all();
        $standings = [];

        foreach ($teams as $team) {
            $matches = MatchGame::where(function ($q) use ($team) {
                $q->where('home_team_id', $team->id)
                    ->orWhere('away_team_id', $team->id);
            })->where('played', true)->get();

            $stats = [
                'team' => [
                    'id' => $team->id,
                    'name' => $team->name,
                ],
                'PTS' => 0,
                'P' => 0,
                'W' => 0,
                'D' => 0,
                'L' => 0,
                'GD' => 0
            ];

            foreach ($matches as $match) {
                if ($match->home_goals === null || $match->away_goals === null) {
                    continue;
                }

                $stats['P']++;

                if ($match->home_team_id == $team->id) {
                    $goalsFor = $match->home_goals;
                    $goalsAgainst = $match->away_goals;
                } else {
                    $goalsFor = $match->away_goals;
                    $goalsAgainst = $match->home_goals;
                }

                $stats['GD'] += $goalsFor - $goalsAgainst;

                if ($goalsFor > $goalsAgainst) {
                    $stats['W']++;
                    $stats['PTS'] += 3;
                } elseif ($goalsFor === $goalsAgainst) {
                    $stats['D']++;
                    $stats['PTS'] += 1;
                } else {
                    $stats['L']++;
                }
            }

            $standings[] = $stats;
        }

        usort($standings, function ($a, $b) {
            return $b['PTS'] <=> $a['PTS'] ?: $b['GD'] <=> $a['GD'];
        });

        return $standings;
    }
}