<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'season'];

    public function matches(): HasMany
    {
        return $this->hasMany(MatchGame::class);
    }

    public function predictions(): HasMany {
        return $this->hasMany(Prediction::class);
    }
}
