<?php

namespace Tests\Unit\Admin\UseCases\Player;

use App\UseCases\Admin\Player\UpdatePlayer;
use Database\Seeders\Test\PlayersSeeder;
use Exception;
use Tests\Unit\Admin\AdminTestCase;

class UpdatePlayerTest extends AdminTestCase
{
    protected $seeder = PlayersSeeder::class;

    public function test_名前を更新できる(): void
    {
        $this->assertDatabaseHas('players', [
            'id' => '01jd18avwedq7701wevkwzk1nt',
            'name' => 'Marc Cucurella',
            'number' => 3,
            'position' => 'D'
        ]);

        $updatePlayer = app(UpdatePlayer::class);

        $updatePlayer->execute('01jd18avwedq7701wevkwzk1nt', ['name' => 'New Name']);

        $this->assertDatabaseHas('players', [
            'id' => '01jd18avwedq7701wevkwzk1nt',
            'name' => 'New Name',
            'number' => 3,
            'position' => 'D'
        ]);
    }

    public function test_ポジションを更新できる(): void
    {
        $this->assertDatabaseHas('players', [
            'id' => '01jd18avwedq7701wevkwzk1nt',
            'name' => 'Marc Cucurella',
            'number' => 3,
            'position' => 'D'
        ]);

        $updatePlayer = app(UpdatePlayer::class);

        $updatePlayer->execute('01jd18avwedq7701wevkwzk1nt', ['position' => 'Forward']);

        $this->assertDatabaseHas('players', [
            'id' => '01jd18avwedq7701wevkwzk1nt',
            'name' => 'Marc Cucurella',
            'number' => 3,
            'position' => 'F'
        ]);
    }

    public function test_不正なポジションの場合エラーを出す(): void
    {
        $this->assertDatabaseHas('players', [
            'id' => '01jd18avwedq7701wevkwzk1nt',
            'name' => 'Marc Cucurella',
            'number' => 3,
            'position' => 'D'
        ]);

        $updatePlayer = app(UpdatePlayer::class);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The selected position is invalid.');
        
        $updatePlayer->execute('01jd18avwedq7701wevkwzk1nt', ['position' => 'Invalid']);
    }

    public function test_背番号を更新できる(): void
    {
        $this->assertDatabaseHas('players', [
            'id' => '01jd18avwedq7701wevkwzk1nt',
            'name' => 'Marc Cucurella',
            'number' => 3,
            'position' => 'D'
        ]);

        $updatePlayer = app(UpdatePlayer::class);

        $updatePlayer->execute('01jd18avwedq7701wevkwzk1nt', ['number' => 99]);

        $this->assertDatabaseHas('players', [
            'id' => '01jd18avwedq7701wevkwzk1nt',
            'name' => 'Marc Cucurella',
            'number' => 99,
            'position' => 'D'
        ]);
    }
}