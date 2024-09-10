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
        Schema::create('game_user', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->boolean('is_rated');
            $table->tinyInteger('mom_count')->unsigned();
            $table->ulid('mom_game_player_id')->nullable();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('game_id')->constrained();
            $table->foreign('mom_game_player_id')->references('id')->on('game_player');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_user');
    }
};
