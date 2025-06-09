<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Week;
use Illuminate\Database\Seeder;

class WeekSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            Week::create([
                'number' => $i,
                'is_current' => $i === 1
            ]);
        }
    }
}
