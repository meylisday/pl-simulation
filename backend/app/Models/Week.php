<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Week extends Model
{
    public function matches(): HasMany
    {
        return $this->hasMany(MatchGame::class);
    }
}
