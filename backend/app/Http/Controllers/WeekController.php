<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Week;
use Illuminate\Http\Response;

class WeekController extends Controller
{
    public function index(): Response
    {
        $weeks = Week::orderBy('number')->get();
        return response($weeks);
    }
}
