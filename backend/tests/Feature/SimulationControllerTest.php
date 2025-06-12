<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Controllers\SimulationController;
use App\Models\League;
use App\Models\MatchGame;
use App\Models\Team;
use App\Models\Week;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimulationControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_simulates_matches_for_given_week()
    {
        $league = League::factory()->create();
        $week = Week::factory()->create(['number' => 1, 'is_current' => true]);

        $teamA = Team::factory()->create(['strength' => 10]);
        $teamB = Team::factory()->create(['strength' => 8]);

        MatchGame::create([
            'league_id' => $league->id,
            'week_id' => $week->id,
            'home_team_id' => $teamA->id,
            'away_team_id' => $teamB->id,
            'played' => false
        ]);

        $controller = new SimulationController();
        $controller->simulateWeek($week->id);

        $match = MatchGame::first();
        $this->assertTrue($match->played);
        $this->assertNotNull($match->home_goals);
        $this->assertNotNull($match->away_goals);
    }
}
