<?php

namespace Tests\Unit\User\UseCases;

use App\Models\GameUser;
use App\UseCases\User\FetchGames;
use App\UseCases\Util\TournamentType;
use Database\Seeders\Test\UserTwentyGamesSeeder;
use Tests\Unit\User\UserTestCase;


class FetchGamesTest extends UserTestCase
{
    protected $seeder = UserTwentyGamesSeeder::class;
    
    public function test_終了している試合10件のみ取得できる(): void
    {
        $fetchGames = app(FetchGames::class);

        $games = $fetchGames->execute(TournamentType::ALL);

        $this->assertSame(10, $games->count());
    }

    public function test_評価可能な試合が2件のみ取得できる(): void
    {
        $fetchGames = app(FetchGames::class);

        $games = $fetchGames->execute(TournamentType::ALL);
        
        $this->assertSame(2, $games->filter(fn($game) => $game->canRate)->count());
    }

    public function test_ECLカップでソートすると3件のみ取得できる(): void
    {
        $fetchGames = app(FetchGames::class);

        $games = $fetchGames->execute(TournamentType::ECL);
        
        $this->assertSame(3, $games->count());
    }

    public function test_リーグカップでソートすると1件のみ取得できる(): void
    {
        $fetchGames = app(FetchGames::class);

        $games = $fetchGames->execute(TournamentType::LEAGUE_CUP);
        
        $this->assertSame(1, $games->count());
    }

    public function test_プレミアリーグでソートすると6件のみ取得できる(): void
    {
        $fetchGames = app(FetchGames::class);

        $games = $fetchGames->execute(TournamentType::PREMIER_LEAGUE);
        
        $this->assertSame(6, $games->count());
    }

    public function test_FAカップでソートすると0件のみ取得できる(): void
    {
        $fetchGames = app(FetchGames::class);

        $games = $fetchGames->execute(TournamentType::FA_CUP);
        
        $this->assertSame(0, $games->count());
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

        $fetchGames = app(FetchGames::class);

        $games = $fetchGames->execute(TournamentType::ALL);

        $vsArsenal = $games->filter(fn($game) => $game->id === '01JD18AVT9AYM6PQMVHFCM4SRB')->first();

        $this->assertTrue($vsArsenal->gameUser->is_rated);
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

        $fetchGames = app(FetchGames::class);

        $games = $fetchGames->execute(TournamentType::ALL);
        
        $vsArsenal = $games->filter(fn($game) => $game->id === '01JD18AVT9AYM6PQMVHFCM4SRB')->first();
        
        $this->assertFalse($vsArsenal->gameUser->is_rated);
    }
}