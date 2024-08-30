<?php declare(strict_types=1);

namespace Database\Factories;

use File\Eloquent\GameModelFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
    
    /**
     * fromFile
     *
     * @param  int $fixtureId
     * @return static
     */
    public function fromFile(int $fixtureId): static
    {
        $file = new GameModelFile;

        $game = $file->get($fixtureId);
        
        return $this->state(fn (array $attributes) => [
            'id' => $game['id'],
            'fixture_id' => $game['fixture_id'],
            'league_id' => $game['league_id'],
            'season' => $game['season'],
            'date' => $game['date'],
            'is_end' => $game['is_end'],
            'score' => $game['score'],
            'teams' => $game['teams'],
            'league' => $game['league'],
        ]);
    }

    public function not_started()
    {
        return $this->state(fn (array $attributes) => [
            'is_end' => false
        ]);
    }
}
