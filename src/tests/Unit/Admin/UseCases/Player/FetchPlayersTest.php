<?php

namespace Tests\Unit\Admin\UseCases\Player;

use Tests\Unit\Admin\AdminTestCase;
use Database\Seeders\Test\PlayersSeeder;
use App\UseCases\Admin\Player\FetchPlayers;


class FetchPlayersTest extends AdminTestCase
{
    protected $seeder = PlayersSeeder::class;

    public function test_今シーズンの選手全て取得できる(): void
    {
        // すべての選手の数
        $this->assertDatabaseCount('players', 45);

        $fetchPlayers = app(FetchPlayers::class);

        $players = $fetchPlayers->execute();

        // 2024シーズンの選手の数
        $this->assertSame(40, $players->count());
    }
}
