<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Response;

class LeagueController extends Controller
{
    public function index(): Response
    {
        $leagues = League::all();
        return response($leagues);
    }
}
