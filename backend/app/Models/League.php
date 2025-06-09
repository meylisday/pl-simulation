<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends Model
{
    public function matches(): HasMany
    {
        return $this->hasMany(MatchGame::class);
    }

    public function predictions(): HasMany {
        return $this->hasMany(Prediction::class);
    }
}
