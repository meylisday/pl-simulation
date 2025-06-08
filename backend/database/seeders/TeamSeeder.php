<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('teams')->insert([
            ['name' => 'Liverpool', 'strength' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Arsenal', 'strength' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Man City', 'strength' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chelsea', 'strength' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
