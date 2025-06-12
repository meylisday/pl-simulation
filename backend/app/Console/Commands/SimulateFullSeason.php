<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\Controllers\SimulationController;
use App\Models\Week;
use Illuminate\Console\Command;

class SimulateFullSeason extends Command
{
    protected $signature = 'simulate:full-season';
    protected $description = 'Simulate a full season with predictions after each week';

    public function handle()
    {
        $simulation = new SimulationController();

        $this->info('--- Resetting the simulation ---');
        $simulation->reset();

        $weeks = Week::orderBy('number')->get();

        foreach ($weeks as $week) {
            $this->info(">>> Simulating week {$week->number}");
            $simulation->simulateNext();

            $this->info(">>> Calculating predictions");
            $simulation->predict();

            usleep(300000);
        }

        $this->info('Full season simulation completed');
    }
}
