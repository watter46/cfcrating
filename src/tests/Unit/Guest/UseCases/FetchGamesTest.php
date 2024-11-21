<?php declare(strict_types=1);

namespace Tests\Unit\Guest\UseCases;

use App\UseCases\Top\FetchGames;
use Database\Seeders\Test\GuestSeeder;
use Tests\Unit\Guest\GuestTestCase;


class FetchGamesTest extends GuestTestCase
{
    protected $seeder = GuestSeeder::class;
    
    /*
        現在時間 UTC 2024-11-11
    
        最新5件
        1208107 2024-10-27 Newcastle
        1310475 2024-10-29 Newcastle   
        1208117 2024-11-04 Manchester United
        1299338 2024-11-07 FC Noah
        1208125 2024-11-10 Arsenal
    */
    
    public function test_最新の5件が取得できる()
    {
        $fetchGames = app(FetchGames::class);

        $games = $fetchGames->execute();

        $this->assertSame(5, $games->count());
    }

    public function test_試合が5日以内に行われたなら評価できる判定である()
    {
        $fetchGames = app(FetchGames::class);

        $games = $fetchGames->execute();

        /**
         * vs Noah
         * vs Arsenal
         * が評価期間内
         */
        $this->assertSame(2, $games->filter(fn($game) => $game->canRate)->count());
    }
}