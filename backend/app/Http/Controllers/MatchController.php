<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\MatchGame;
use Illuminate\Http\Response;

class MatchController extends Controller
{
    public function index(): Response
    {
        $matches = MatchGame::with(['homeTeam', 'awayTeam', 'week'])->get();
        return response($matches);
    }

    public function byWeek(int $weekId): Response
    {
        $matches = MatchGame::where('week_id', $weekId)
            ->with(['homeTeam', 'awayTeam'])
            ->orderBy('id')
            ->get();

        return response($matches);
    }
}
