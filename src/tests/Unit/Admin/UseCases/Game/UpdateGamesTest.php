<?php

namespace Tests\Unit\Admin\UseCases\Game;

use App\File\Data\FixtureFile;
use App\File\Data\Test\ApiFootball\FixturesFile;
use App\Infrastructure\ApiFootball\TestApiFootballRepository;
use App\Models\Game;
use App\UseCases\Admin\Game\GameRepositoryInterface;
use App\UseCases\Admin\Game\UpdateGames;
use Database\Seeders\Test\AdminFiveGamesSeeder;
use Illuminate\Support\Facades\Storage;
use Tests\Unit\Admin\AdminTestCase;


class UpdateGamesTest extends AdminTestCase
{
    protected $seeder = AdminFiveGamesSeeder::class;
    
    public function test_ApiFootballから取得したfixturesをDBに保存できる(): void
    {
        // 5件のデータ
        $this->assertDatabaseCount('games', 5);
        $this->assertDatabaseHas('games', ['fixture_id' => 1208074]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1299304]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1208085]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1208094]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1299319]);
        
        $repository = new TestApiFootballRepository(new FixturesFile, new FixtureFile);
        
        $updateGames = new UpdateGames($repository, app(GameRepositoryInterface::class));
        $updateGames->execute();

        // 新たに5件追加されているか
        $this->assertDatabaseCount('games', 10);
        $this->assertDatabaseHas('games', ['fixture_id' => 1208107]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1310475]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1208117]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1299338]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1208125]);
    }

    public function test_未保存のチーム画像を取得して保存できる(): void
    {
        Storage::fake('public');
        
        $teamIds = [40, 49, 51, 65, 617, 631];

        foreach ($teamIds as $teamId) {
            $realFilePath = storage_path("app/public/image/team/$teamId");

            Storage::disk('public')->put("app/public/image/team/$teamId", file_get_contents($realFilePath));
        }

        $this->assertFileExists("storage/app/public/image/team/40");
        $this->assertFileExists("storage/app/public/image/team/49");
        $this->assertFileExists("storage/app/public/image/team/51");
        $this->assertFileExists("storage/app/public/image/team/65");
        $this->assertFileExists("storage/app/public/image/team/617");
        $this->assertFileExists("storage/app/public/image/team/631");
        
        // 5件のデータ
        $this->assertDatabaseCount('games', 5);
        $this->assertDatabaseHas('games', ['fixture_id' => 1208074]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1299304]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1208085]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1208094]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1299319]);
         
        $repository = new TestApiFootballRepository(new FixturesFile, new FixtureFile);
         
        $updateGames = new UpdateGames($repository, app(GameRepositoryInterface::class));
        $updateGames->execute();
        
        $this->assertFileExists("storage/app/public/image/team/40");
        $this->assertFileExists("storage/app/public/image/team/49");
        $this->assertFileExists("storage/app/public/image/team/51");
        $this->assertFileExists("storage/app/public/image/team/65");
        $this->assertFileExists("storage/app/public/image/team/617");
        $this->assertFileExists("storage/app/public/image/team/631");
        
        // 新たに4件追加されているか
        $this->assertFileExists("storage/app/public/image/team/33");
        $this->assertFileExists("storage/app/public/image/team/34");
        $this->assertFileExists("storage/app/public/image/team/42");
        $this->assertFileExists("storage/app/public/image/team/3684");
    }

    public function test_未保存のリーグ画像を取得して保存できる(): void
    {
        Storage::fake('public');
        
        $leagueIds = [39, 848];

        foreach ($leagueIds as $leagueId) {
            $realFilePath = storage_path("app/public/image/league/$leagueId");

            Storage::disk('public')->put("app/public/image/league/$leagueId", file_get_contents($realFilePath));
        }

        $this->assertFileExists("storage/app/public/image/league/39");
        $this->assertFileExists("storage/app/public/image/league/848");
        
        // 5件のデータ
        $this->assertDatabaseCount('games', 5);
        $this->assertDatabaseHas('games', ['fixture_id' => 1208074]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1299304]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1208085]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1208094]);
        $this->assertDatabaseHas('games', ['fixture_id' => 1299319]);
         
        $repository = new TestApiFootballRepository(new FixturesFile, new FixtureFile);
         
        $updateGames = new UpdateGames($repository, app(GameRepositoryInterface::class));
        $updateGames->execute();
        
        $this->assertFileExists("storage/app/public/image/league/39");
        $this->assertFileExists("storage/app/public/image/league/848");
        
        // 新たに1件追加されているか
        $this->assertFileExists("storage/app/public/image/team/48");
    }
}