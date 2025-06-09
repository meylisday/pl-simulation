<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\League;
use Illuminate\Database\Seeder;

class LeagueSeeder extends Seeder
{
    public function run(): void
    {
        League::create([
            'name' => 'Premier League Simulation',
            'season' => '2024/25'
        ]);
    }
}
