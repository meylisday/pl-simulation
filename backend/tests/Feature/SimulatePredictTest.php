<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\League;
use App\Models\MatchGame;
use App\Models\Team;
use App\Models\Week;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimulatePredictTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_generate_predictions()
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

        $this->postJson('/api/simulate/next');

        $response = $this->postJson('/api/simulate/predict');

        $response->assertOk();
        $this->assertDatabaseCount('predictions', 4);
    }
}
