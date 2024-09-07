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
        Schema::create('game_player', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->boolean('is_starter');
            $table->tinyText('grid')->nullable();
            $table->tinyInteger('assists')->unsigned();
            $table->tinyInteger('goals')->unsigned();
            $table->float('rating', 3, 1)->unsigned()->nullable();

            $table->foreignUlid('game_id')->constrained();
            $table->foreignUlid('player_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_player');
    }
};
