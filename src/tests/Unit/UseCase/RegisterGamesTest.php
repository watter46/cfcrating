<?php declare(strict_types=1);

namespace Tests\Unit\UseCase;

use App\UseCases\Admin\RegisterGames;
use Tests\TestCase;


class RegisterGamesTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }
    
    public function test_年間のGameを保存できる()
    {
        $this->assertDatabaseCount('games', 0);
        
        $registerGames = app(RegisterGames::class);

        $registerGames->execute();

        $this->assertDatabaseCount('games', 57);
    }
}