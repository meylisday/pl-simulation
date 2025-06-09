<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TeamSeeder::class,
            LeagueSeeder::class,
            WeekSeeder::class,
            MatchGameSeeder::class,
        ]);
    }
}
