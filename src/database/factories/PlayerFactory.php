<?php declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
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
     * @param  Collection $player
     * @return static
     */
    public function fromFile(Collection $player): static
    {
        return $this->state(fn (array $attributes) => [
            'name'           => $player['name'],
            'position'       => 'M',
            'season'         => $player['season'],
            'number'         => $player['number'],
            'api_player_id'  => $player['api_player_id'],
            'is_fetched'     => false,
            'flash_id'       => $player['flash_id'],
            'flash_image_id' => $player['flash_image_id']
        ]);
    }
}
