<?php declare(strict_types=1);

namespace Tests\Unit\UseCase;

use App\Models\Game;
use App\UseCases\Admin\Command\GameCommand;
use App\UseCases\Admin\RegisterGame;
use Tests\TestCase;


class RegisterGameTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }
    
    public function test_指定のGameを保存できる()
    {
        Game::factory()->fromFile(1035480)->not_started()->create();

        $gameId = Game::fixtureId(1035480)->first()->id;
        
        $this->assertDatabaseHas('games', [
            'id' => $gameId,
            'fixture_id' => 1035480,
            'is_end' => false
        ]);
        
        $registerGames = app(RegisterGame::class);

        $command = new GameCommand($gameId);
        
        $registerGames->execute($command);

        $this->assertDatabaseHas('games', [
            'id' => $gameId,
            'fixture_id' => 1035480,
            'is_end' => true
        ]);
    }
}