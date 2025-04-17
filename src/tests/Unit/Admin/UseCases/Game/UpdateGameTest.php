<?php

namespace Tests\Unit\Admin\UseCases\Game;

use Tests\Unit\Admin\AdminTestCase;
use Illuminate\Support\Facades\Event;
use Database\Seeders\Test\PlayersSeeder;
use Database\Seeders\Test\GameSeeder;
use App\UseCases\Admin\Game\UpdateGame;
use App\UseCases\Admin\Game\GameRepositoryInterface;
use App\Infrastructure\ApiFootball\TestApiFootballRepository;
use App\File\Data\Test\ApiFootball\FixturesFile;
use App\File\Data\FixtureFile;
use App\Events\UpdateGameImages;

class UpdateGameTest extends AdminTestCase
{
    protected $seeder = [GameSeeder::class, PlayersSeeder::class];

    public function setUp(): void
    {
        parent::setUp();

        /**
         * 1208040 2024-08-25 Wolves 01JD18AVT8PHWC5YRH6EERNW2N
         */
        $this->assertDatabaseHas('games', [
            'id' => '01JD18AVT8PHWC5YRH6EERNW2N',
            'fixture_id' => 1208040
        ]);

        $this->assertDatabaseCount('players', 45);
    }

    public function test_ApiFootballから取得したfixtureをDBに保存できる(): void
    {
        Event::fake();

        $repository = new TestApiFootballRepository(new FixturesFile, new FixtureFile);

        $updateGames = new UpdateGame($repository, app(GameRepositoryInterface::class));
        $updateGames->execute('01JD18AVT8PHWC5YRH6EERNW2N');

        // GamePlayerが16件追加されているか
        $this->assertDatabaseCount('game_player', 16);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwedq7701wevkwzk1np']);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwedq7701wevkwzk1nz']);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwfdbqnn9r4xnhwkffq']);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwedq7701wevkwzk1ny']);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwedq7701wevkwzk1nt']);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwfdbqnn9r4xnhwkffx']);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwfdbqnn9r4xnhwkffs']);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwgpx3m9msaw5djmf06']);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwgpx3m9msaw5djmf0a']);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwfdbqnn9r4xnhwkfft']);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwgpx3m9msaw5djmf07']);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwgpx3m9msaw5djmf0f']);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwgpx3m9msaw5djmf0h']);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwgpx3m9msaw5djmf03']);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwfdbqnn9r4xnhwkffz']);
        $this->assertDatabaseHas('game_player', ['player_id' => '01jd18avwgpx3m9msaw5djmf08']);

        Event::assertDispatched(UpdateGameImages::class);
    }
}
