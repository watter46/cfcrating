<?php

namespace Tests\Unit\Admin\UseCases\Game;

use App\Models\GamePlayer;
use App\UseCases\Admin\Game\UpdateGamePlayer;
use Database\Seeders\Test\UserOneGameSeeder;
use Tests\Unit\Admin\AdminTestCase;


class UpdateGamePlayerTest extends AdminTestCase
{
    protected $seeder = UserOneGameSeeder::class;
    
    public function test_Goal数を更新できる(): void
    {
        /** 1208040 2024-08-25 Wolves 01JD18AVT8PHWC5YRH6EERNW2N */
        /** 01jd18avzkyr2bj21ardp1hnkx Marc Cucurella */

        $this->assertDatabaseHas('game_player', [
            'id' => '01jd18avzkyr2bj21ardp1hnkx',
            'is_starter' => true,
            'grid' => '2:1',
            'assists' => 0,
            'goals' => 0,
            'rating' => 7,
            'game_id' => '01JD18AVT8PHWC5YRH6EERNW2N',
            'player_id' => '01jd18avwedq7701wevkwzk1nt'
        ]);
        
        $updateGamePlayer = app(UpdateGamePlayer::class);
        $updateGamePlayer->execute('01jd18avzkyr2bj21ardp1hnkx', ['goals' => 3, 'assists' => 0]);

        $this->assertDatabaseHas('game_player', [
            'id' => '01jd18avzkyr2bj21ardp1hnkx',
            'is_starter' => true,
            'grid' => '2:1',
            'assists' => 0,
            'goals' => 3,
            'rating' => 7,
            'game_id' => '01JD18AVT8PHWC5YRH6EERNW2N',
            'player_id' => '01jd18avwedq7701wevkwzk1nt'
        ]);
    }

    public function test_Assist数を更新できる(): void
    {
        /** 1208040 2024-08-25 Wolves 01JD18AVT8PHWC5YRH6EERNW2N */
        /** 01jd18avzkyr2bj21ardp1hnkx Marc Cucurella */

        $this->assertDatabaseHas('game_player', [
            'id' => '01jd18avzkyr2bj21ardp1hnkx',
            'is_starter' => true,
            'grid' => '2:1',
            'assists' => 0,
            'goals' => 0,
            'rating' => 7,
            'game_id' => '01JD18AVT8PHWC5YRH6EERNW2N',
            'player_id' => '01jd18avwedq7701wevkwzk1nt'
        ]);
        
        $updateGamePlayer = app(UpdateGamePlayer::class);
        $updateGamePlayer->execute('01jd18avzkyr2bj21ardp1hnkx', ['goals' => 0, 'assists' => 3]);

        $this->assertDatabaseHas('game_player', [
            'id' => '01jd18avzkyr2bj21ardp1hnkx',
            'is_starter' => true,
            'grid' => '2:1',
            'assists' => 3,
            'goals' => 0,
            'rating' => 7,
            'game_id' => '01JD18AVT8PHWC5YRH6EERNW2N',
            'player_id' => '01jd18avwedq7701wevkwzk1nt'
        ]);
    }
}