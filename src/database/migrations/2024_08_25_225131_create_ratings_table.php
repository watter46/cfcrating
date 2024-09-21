<?php declare(strict_types=1);

use App\Models\GamePlayer;
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
        Schema::create('ratings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->float('rating', 3, 1)->nullable()->unsigned()->checkBetween([3, 10.0]);
            $table->tinyInteger('rate_count')->unsigned();

            $table->foreignId('user_id')->constrained();
            $table->foreignUlid('game_player_id')->constrained('game_player');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
