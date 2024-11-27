<?php

namespace Tests\Unit\Admin\UseCases\Player;

use App\Infrastructure\FlashLive\InMemoryFlashLiveRepository;
use App\Models\Player;
use App\UseCases\Admin\Player\UpdateFlash;
use Database\Seeders\Test\PlayersSeeder;
use Exception;
use Mockery\MockInterface;
use Tests\Unit\Admin\AdminTestCase;


class UpdateFlashTest extends AdminTestCase
{
    protected $seeder = PlayersSeeder::class;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * id: 01jd18avwgpx3m9msaw5djmf0j
         * name: Jadon Sancho
         * position: F
         * number: 19
         * api_player_id: 18
         * flash_id: n5mG9yn6
         * flash_image_id: lhETALHG-jFu5NFr0
         */
        
    }
    
    public function test_flashIdがnullの選手をFlashLiveから取得してflashIdとflashImageIdを更新できる(): void
    {
        // flash_id flash_image_idをnullにする
        Player::find('01jd18avwgpx3m9msaw5djmf0j')
            ->update([
                'flash_id' => null,
                'flash_image_id' => null,
                'is_fetched' => false
            ]);

        $this->assertDatabaseHas('players', [
            'id' => '01jd18avwgpx3m9msaw5djmf0j',
            'flash_id' => null,
            'flash_image_id' => null
        ]);
        
        $updateFlash = new UpdateFlash(app(InMemoryFlashLiveRepository::class));
        $updateFlash->execute('01jd18avwgpx3m9msaw5djmf0j');

        $this->assertDatabaseHas('players', [
            'id' => '01jd18avwgpx3m9msaw5djmf0j',
            'flash_id' => 'n5mG9yn6',
            'flash_image_id' => 'lhETALHG-jFu5NFr0',
            'is_fetched' => true
        ]);
    }

    public function test_名前が省略形ならフルネームで保存できる(): void
    {
        // nameを省略形にする
        Player::find('01jd18avwgpx3m9msaw5djmf0j')
            ->update([
                'name' => 'J. Sancho',
                'flash_id' => null,
                'flash_image_id' => null,
                'is_fetched' => false
            ]);

        $this->assertDatabaseHas('players', [
            'id' => '01jd18avwgpx3m9msaw5djmf0j',
            'name' => 'J. Sancho'
        ]);
        
        $updateFlash = new UpdateFlash(app(InMemoryFlashLiveRepository::class));
        $updateFlash->execute('01jd18avwgpx3m9msaw5djmf0j');

        $this->assertDatabaseHas('players', [
            'id' => '01jd18avwgpx3m9msaw5djmf0j',
            'name' => 'Jadon Sancho',
            'is_fetched' => true
        ]);
    }

    public function test_FlashLiveからデータを取得したことがある場合は例外を投げる(): void
    {
        // flash_id flash_image_idをnull is_fetchedをtrueにする
        Player::find('01jd18avwgpx3m9msaw5djmf0j')
            ->update([
                'flash_id' => null,
                'flash_image_id' => null,
                'is_fetched' => true
            ]);

        $this->assertDatabaseHas('players', [
            'id' => '01jd18avwgpx3m9msaw5djmf0j',
            'flash_id' => null,
            'flash_image_id' => null,
            'is_fetched' => true
        ]);
        
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The player has already been retrieved.');
        
        $updateFlash = new UpdateFlash(app(InMemoryFlashLiveRepository::class));
        $updateFlash->execute('01jd18avwgpx3m9msaw5djmf0j');
    }
}