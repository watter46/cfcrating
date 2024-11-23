<?php

namespace Tests\Unit\Admin\UseCases;

use App\UseCases\Admin\Game\FindGame;
use Database\Seeders\Test\UserTwentyGamesSeeder;
use Tests\Unit\Admin\AdminTestCase;


class FindGameTest extends AdminTestCase
{
    protected $seeder = UserTwentyGamesSeeder::class;
    
    public function test_指定の試合を取得できる(): void
    {
        // (vs Manchester United) 01JD18AVT9AYM6PQMVHFCM4SRA

        $this->assertDatabaseCount('games', 20);

        $findGame = app(FindGame::class);

        $vsManUnited = $findGame->execute('01JD18AVT9AYM6PQMVHFCM4SRA');
        
        $this->assertSame('01JD18AVT9AYM6PQMVHFCM4SRA', $vsManUnited['id']);
    }
}