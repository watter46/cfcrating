<?php

namespace Tests\Unit\Admin\UseCases\Game;

use Database\Seeders\Test\UserTwentyGamesSeeder;
use Illuminate\Support\Carbon;
use Tests\Unit\Admin\AdminTestCase;

use App\UseCases\Admin\Game\FetchGames;


class FetchGamesTest extends AdminTestCase
{
    protected $seeder = UserTwentyGamesSeeder::class;
    
    public function test_今日までの最新の試合10件を取得できる(): void
    {
        // 日時を2024-11-11に設定

        $fetchGames = app(FetchGames::class);

        $games = $fetchGames->execute();

        $this->assertSame(10, $games->count());
    }

    public function test_試合当日で試合開始時刻後は取得できる(): void
    {
        // 日時を2024-11-10 16:30:00に設定 (vs Arsenal試合開始時刻 2024-11-10 16:30:00)
        Carbon::setTestNow('2024-11-10 16:30:00');

        $fetchGames = app(FetchGames::class);

        $games = $fetchGames->execute();

        $existGame = $games
            ->filter(fn($game) => $game->id === '01JD18AVT9AYM6PQMVHFCM4SRB')
            ->count();

        $this->assertSame(1, $existGame);
    }

    public function test_試合当日で試合開始時刻前の場合は取得できない(): void
    {
        // 日時を2024-11-10 16:29:00に設定 (vs Arsenal試合開始時刻 2024-11-10 16:30:00)
        Carbon::setTestNow('2024-11-10 16:29:00');

        $fetchGames = app(FetchGames::class);

        $games = $fetchGames->execute();

        $existGame = $games
            ->filter(fn($game) => $game->id === '01JD18AVT9AYM6PQMVHFCM4SRB')
            ->count();

        $this->assertSame(0, $existGame);
    }
}