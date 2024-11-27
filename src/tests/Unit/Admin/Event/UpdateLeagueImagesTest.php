<?php

namespace Tests\Unit\Admin\Event;

use App\UseCases\Admin\Game\UpdateGame;
use Database\Seeders\Test\GamePlayerImagesSeeder;
use Database\Seeders\Test\GameSeeder;
use Database\Seeders\Test\GameTeamImagesSeeder;
use Tests\Unit\Admin\AdminTestCase;


class UpdateLeagueImagesTest extends AdminTestCase
{
    protected $seeder = [
        GameSeeder::class,
        GameTeamImagesSeeder::class,
        GamePlayerImagesSeeder::class
    ];
    
    /**
     * 1208040 2024-08-25 Wolves 01JD18AVT8PHWC5YRH6EERNW2N
     */
    public function test_不足分のリーグ画像を保存できる(): void
    {
        $updateGame = app(UpdateGame::class);
        $updateGame->execute('01JD18AVT8PHWC5YRH6EERNW2N');
        
        // leagueId:39のチーム画像が追加されているか
        $this->assertFileExists("storage/app/public/image/league/39");
    }
}