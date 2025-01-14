<?php

namespace Tests\Unit\Admin\UseCases\Player;

use App\UseCases\Admin\Player\FetchPlayers;
use Database\Seeders\Test\PlayersSeeder;
use Tests\Unit\Admin\AdminTestCase;


class FetchPlayersTest extends AdminTestCase
{
    protected $seeder = PlayersSeeder::class;
    
    public function test_今シーズンの選手全て取得できる(): void
    {
        // すべての選手の数
        $this->assertDatabaseCount('players', 42);

        $fetchPlayers = app(FetchPlayers::class);

        $players = $fetchPlayers->execute();

        // 2024シーズンの選手の数
        $this->assertSame(37, $players->count());
    }
}