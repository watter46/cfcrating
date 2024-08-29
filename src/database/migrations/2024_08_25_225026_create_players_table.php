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
        Schema::create('players', function (Blueprint $table) {
            $table->ulid('id');
            $table->tinyText('name');
            $table->tinyText('position');
            $table->smallInteger('season')->length(4)->unsigned();
            $table->tinyInteger('number')->nullable()->unsigned();
            $table->mediumInteger('api_player_id')->unsigned();
            $table->tinyText('flash_id')->nullable();
            $table->tinyText('flash_image_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
