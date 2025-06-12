<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PredictionController extends Controller
{
    public function index(): Response
    {
        $predictions = Prediction::with('team')->get()->groupBy('team_id');

        $result = $predictions->map(function ($items) {
            $team = $items->first()->team;
            $positions = $items->map(function ($item) {
                return [
                    'position' => $item->position,
                    'probability' => $item->probability,
                ];
            });

            return [
                'team' => [
                    'id' => $team->id,
                    'name' => $team->name,
                    'strength' => $team->strength,
                ],
                'positions' => $positions,
            ];
        })->values();

        return response($result);
    }
}
