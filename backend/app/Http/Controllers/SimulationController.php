<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\League;
use App\Models\MatchGame;
use App\Models\Prediction;
use App\Models\Team;
use App\Models\Week;
use Illuminate\Http\Response;

class SimulationController extends Controller
{
    public function simulateWeek(int $weekId): Response
    {
        $matches = MatchGame::where('week_id', $weekId)->where('played', false)->get();

        foreach ($matches as $match) {
            $homeStrength = $match->homeTeam->strength;
            $awayStrength = $match->awayTeam->strength;

            $match->home_goals = rand(0, $homeStrength % 5 + 2);
            $match->away_goals = rand(0, $awayStrength % 5 + 2);
            $match->played = true;
            $match->save();
        }

        return response(['message' => 'Week simulated', 'matches_played' => count($matches)]);
    }

    public function simulateNext(): Response
    {
        $week = Week::where('is_current', true)->first();
        if (!$week) {
            return response(['error' => 'No current week found'], 404);
        }

        $response = $this->simulateWeek($week->id);

        $nextWeek = Week::where('number', '>', $week->number)->orderBy('number')->first();
        if ($nextWeek) {
            $week->is_current = false;
            $week->save();

            $nextWeek->is_current = true;
            $nextWeek->save();
        }

        return $response;
    }

    public function reset(): Response
    {
        MatchGame::query()->update([
            'home_goals' => null,
            'away_goals' => null,
            'played' => false
        ]);

        Week::query()->update(['is_current' => false]);

        Week::orderBy('number')->first()?->update(['is_current' => true]);

        return response(['message' => 'Simulation reset']);
    }

    public function predict(): Response
    {
        $teams = Team::all();
        $simulations = 1000;
        $positions = [];

        foreach ($teams as $team) {
            $positions[$team->id] = array_fill(1, count($teams), 0);
        }

        for ($i = 0; $i < $simulations; $i++) {
            $scores = [];

            foreach ($teams as $team) {
                $playedMatches = MatchGame::where(function ($q) use ($team) {
                    $q->where('home_team_id', $team->id)->orWhere('away_team_id', $team->id);
                })->where('played', true)->get();

                $points = 0;

                foreach ($playedMatches as $match) {
                    if (!$match->played) continue;

                    if ($match->home_team_id == $team->id) {
                        if ($match->home_goals > $match->away_goals) {
                            $points += 3;
                        }
                        elseif ($match->home_goals == $match->away_goals) {
                            $points += 1;
                        }
                    } elseif ($match->away_team_id == $team->id) {
                        if ($match->away_goals > $match->home_goals) {
                            $points += 3;
                        }
                        elseif ($match->home_goals == $match->away_goals) {
                            $points += 1;
                        }
                    }
                }

                $futureMatches = MatchGame::where(function ($q) use ($team) {
                    $q->where('home_team_id', $team->id)->orWhere('away_team_id', $team->id);
                })->where('played', false)->get();

                foreach ($futureMatches as $match) {
                    $homeStrength = $match->homeTeam->strength;
                    $awayStrength = $match->awayTeam->strength;
                    $homeGoals = rand(0, $homeStrength % 5 + 2);
                    $awayGoals = rand(0, $awayStrength % 5 + 2);

                    if ($match->home_team_id == $team->id) {
                        if ($homeGoals > $awayGoals) {
                            $points += 3;
                        }
                        elseif ($homeGoals == $awayGoals) {
                            $points += 1;
                        }
                    } elseif ($match->away_team_id == $team->id) {
                        if ($awayGoals > $homeGoals) {
                            $points += 3;
                        }
                        elseif ($homeGoals == $awayGoals) {
                            $points += 1;
                        }
                    }
                }

                $scores[$team->id] = $points;
            }

            arsort($scores);
            $rank = 1;
            foreach (array_keys($scores) as $teamId) {
                $positions[$teamId][$rank]++;
                $rank++;
            }
        }

        Prediction::truncate();

        foreach ($positions as $teamId => $posData) {
            foreach ($posData as $position => $count) {
                Prediction::create([
                    'team_id' => $teamId,
                    'league_id' => League::first()->id,
                    'position' => $position,
                    'probability' => $count / $simulations
                ]);
            }
        }

        return response(['message' => 'Predictions calculated']);
    }
}
