<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\StandingsService;
use Illuminate\Http\JsonResponse;

class StandingsController extends Controller
{
    public function index(StandingsService $service): JsonResponse
    {
        $standings = $service->getStandings();
        return response()->json($standings);
    }
}
