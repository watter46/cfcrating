<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_ratings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->float('rating', 3, 1)->nullable()->unsigned()->checkBetween([3, 10.0]);
            $table->boolean('is_mom');
            
            $table->foreignUlid('game_player_id')->constrained('game_player');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_ratings');
    }
};
