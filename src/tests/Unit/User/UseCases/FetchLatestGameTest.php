<?php

namespace Tests\Unit\User\UseCases;

use App\Models\GameUser;
use App\UseCases\User\FetchLatestGame;
use Database\Seeders\Test\UserFiveGamesSeeder;
use Tests\Unit\User\UserTestCase;

class FetchLatestGameTest extends UserTestCase
{
    protected $seeder = UserFiveGamesSeeder::class;

    /** 1208125 2024-11-10 PL Arsenal */
    public function test_最新の試合を取得できる(): void
    {
        $fetchLatestGame = app(FetchLatestGame::class);

        $game = $fetchLatestGame->execute();
        
        $this->assertSame(1208125, $game->get('fixture_id'));
    }

    public function test_ユーザーが評価していればisRateがtrueを返す()
    {
        // UserId:1のGameUserを作成 ログイン中はUserId:1
        GameUser::forceCreate([
            'id' => '01jd18awhs95wvtf5mv37m556n',
            'is_rated' => 1,
            'mom_count' => 0,
            'mom_game_player_id' => null,
            'user_id' => 1,
            'game_id' => '01JD18AVT9AYM6PQMVHFCM4SRB'
        ]);

        $fetchLatestGame = app(FetchLatestGame::class);

        $vsArsenal = $fetchLatestGame->execute();

        $this->assertTrue($vsArsenal->getDotRaw('game_user.is_rated'));
    }

    public function test_ユーザーが評価していなければisRateがfalseを返す()
    {
        // UserId:2のGameUserを作成 ログイン中はUserId:1
        GameUser::forceCreate([
            'id' => '01jd18awhs95wvtf5mv37m556n',
            'is_rated' => 1,
            'mom_count' => 0,
            'mom_game_player_id' => null,
            'user_id' => 2,
            'game_id' => '01JD18AVT9AYM6PQMVHFCM4SRB'
        ]);

        $fetchLatestGame = app(FetchLatestGame::class);

        $vsArsenal = $fetchLatestGame->execute();
        
        $this->assertFalse($vsArsenal->getDotRaw('game_user.is_rated'));
    }
}