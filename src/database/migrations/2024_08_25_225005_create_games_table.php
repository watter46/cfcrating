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
        Schema::create('games', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->mediumInteger('fixture_id')->unsigned();
            $table->mediumInteger('league_id')->unsigned();
            $table->smallInteger('season')->length(4)->unsigned();
            $table->timestamp('date');
            $table->boolean('is_end');
            $table->json('score');
            $table->json('teams');
            $table->json('league');
            $table->boolean('is_details_fetched')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
