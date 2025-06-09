<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prediction extends Model
{
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function league(): BelongsTo {
        return $this->belongsTo(League::class);
    }
}
