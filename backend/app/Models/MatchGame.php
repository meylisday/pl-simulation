<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchGame extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'league_id',
        'week_id',
        'home_team_id',
        'away_team_id',
        'home_goals',
        'away_goals',
        'played'
    ];

    protected $casts = [
        'played' => 'boolean',
    ];

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam(): BelongsTo {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function week(): BelongsTo {
        return $this->belongsTo(Week::class);
    }

    public function league(): BelongsTo {
        return $this->belongsTo(League::class);
    }
}