<?php

namespace Tests\Unit\User\UseCases;

use App\Models\GameUser;
use App\UseCases\User\FindGame;
use Database\Seeders\Test\UserFiveGamesSeeder;
use Tests\Unit\User\UserTestCase;


class FindGameTest extends UserTestCase
{
    protected $seeder = UserFiveGamesSeeder::class;

    /** 1208117 2024-11-04 PL  Manchester United 01JD18AVT9AYM6PQMVHFCM4SRA */
    public function test_最新の試合を取得できる(): void
    {
        $fetchLatestGame = app(FindGame::class);

        $game = $fetchLatestGame->execute('01JD18AVT9AYM6PQMVHFCM4SRA');
        
        $this->assertSame('01JD18AVT9AYM6PQMVHFCM4SRA', $game->get('id'));
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
            'game_id' => '01JD18AVT9AYM6PQMVHFCM4SRA'
        ]);

        $findGame = app(FindGame::class);

        $vsManUnited = $findGame->execute('01JD18AVT9AYM6PQMVHFCM4SRA');

        $this->assertTrue($vsManUnited->getDotRaw('game_user.is_rated'));
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
            'game_id' => '01JD18AVT9AYM6PQMVHFCM4SRA'
        ]);

        $findGame = app(FindGame::class);

        $vsManUnited = $findGame->execute('01JD18AVT9AYM6PQMVHFCM4SRA');
        
        $this->assertFalse($vsManUnited->getDotRaw('game_user.is_rated'));
    }
}
