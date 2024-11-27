<?php

namespace Tests\Unit\Admin\Event;

use App\UseCases\Admin\Game\UpdateGame;
use Database\Seeders\Test\GameLeagueImageSeeder;
use Database\Seeders\Test\GameSeeder;
use Database\Seeders\Test\GameTeamImagesSeeder;
use Tests\Unit\Admin\AdminTestCase;


class UpdatePlayerImagesTest extends AdminTestCase
{
    protected $seeder = [
        GameSeeder::class,
        GameTeamImagesSeeder::class,
        GameLeagueImageSeeder::class
    ];
    
    /**
     * 1208040 2024-08-25 Wolves 01JD18AVT8PHWC5YRH6EERNW2N
     */
    public function test_不足分の選手画像を保存できる(): void
    {
        $updateGame = app(UpdateGame::class);
        $updateGame->execute('01JD18AVT8PHWC5YRH6EERNW2N');

        // 16件の選手画像が追加されているか
        $this->assertFileExists("storage/app/public/image/player/18959.png");
        $this->assertFileExists("storage/app/public/image/player/161907.png");
        $this->assertFileExists("storage/app/public/image/player/22094.png");
        $this->assertFileExists("storage/app/public/image/player/152953.png");
        $this->assertFileExists("storage/app/public/image/player/47380.png");
        $this->assertFileExists("storage/app/public/image/player/116117.png");
        $this->assertFileExists("storage/app/public/image/player/5996.png");
        $this->assertFileExists("storage/app/public/image/player/136723.png");
        $this->assertFileExists("storage/app/public/image/player/152982.png");
        $this->assertFileExists("storage/app/public/image/player/63577.png");
        $this->assertFileExists("storage/app/public/image/player/283058.png");
        $this->assertFileExists("storage/app/public/image/player/1864.png");
        $this->assertFileExists("storage/app/public/image/player/583.png");
        $this->assertFileExists("storage/app/public/image/player/148099.png");
        $this->assertFileExists("storage/app/public/image/player/336671.png");
        $this->assertFileExists("storage/app/public/image/player/269.png");
    }
}