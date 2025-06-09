<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained()->onDelete('cascade');
            $table->foreignId('week_id')->constrained()->onDelete('cascade');
            $table->foreignId('home_team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('away_team_id')->constrained('teams')->onDelete('cascade');
            $table->unsignedTinyInteger('home_goals')->nullable();
            $table->unsignedTinyInteger('away_goals')->nullable();
            $table->boolean('played')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
