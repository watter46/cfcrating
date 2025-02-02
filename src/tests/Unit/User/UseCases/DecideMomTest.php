<?php

namespace Tests\Unit\User\UseCases;

use App\Models\GameUser;
use App\UseCases\User\DecideMom;
use App\UseCases\User\DomainException;
use Database\Seeders\Test\UserOneGameSeeder;
use Illuminate\Support\Carbon;
use Tests\Unit\User\UserTestCase;

class DecideMomTest extends UserTestCase
{
    protected $seeder = UserOneGameSeeder::class;

    public function test_指定の選手をMOMに決定する(): void
    {
        GameUser::forceCreate([
            'user_id' => 1,
            'game_id' => '01JD18AVT8PHWC5YRH6EERNW2N'
        ]);

        // 現在時間を試合翌日にする
        Carbon::setTestNow('2024-08-25');

        $decideMom = app(DecideMom::class);

        $gameId = '01JD18AVT8PHWC5YRH6EERNW2N';
        $gamePlayerId = '01jjyq12j4391yv97qvt0sh49r';

        $response = $decideMom->execute($gameId, $gamePlayerId);

        $this->assertSame($gamePlayerId, $response['id']);
        $this->assertTrue($response['canMom']);
        $this->assertSame(1, $response['momCount']);

        $this->assertDatabaseHas('game_user', [
            'user_id' => 1,
            'game_id' => '01JD18AVT8PHWC5YRH6EERNW2N',
            'mom_count' => 1,
            'mom_game_player_id' => '01jjyq12j4391yv97qvt0sh49r'
        ]);
    }

    public function test_MOMカウントの上限になった場合はcanMomがfalseを返す(): void
    {
        GameUser::forceCreate([
            'mom_count' => 4,
            'user_id' => 1,
            'game_id' => '01JD18AVT8PHWC5YRH6EERNW2N'
        ]);

        // 現在時間を試合翌日にする
        Carbon::setTestNow('2024-08-25');

        $decideMom = app(DecideMom::class);

        $gameId = '01JD18AVT8PHWC5YRH6EERNW2N';
        $gamePlayerId = '01jjyq12j4391yv97qvt0sh49r';

        $response = $decideMom->execute($gameId, $gamePlayerId);

        $this->assertSame($gamePlayerId, $response['id']);
        $this->assertFalse($response['canMom']);
        $this->assertSame(5, $response['momCount']);

        $this->assertDatabaseHas('game_user', [
            'user_id' => 1,
            'game_id' => '01JD18AVT8PHWC5YRH6EERNW2N',
            'mom_count' => 5,
            'mom_game_player_id' => '01jjyq12j4391yv97qvt0sh49r'
        ]);
    }

    public function test_評価可能期間外の場合はMOMを決定できない(): void
    {
        // 現在時間を期間外にする
        Carbon::setTestNow('2024-11-11');

        $decideMom = app(DecideMom::class);

        $gameId = '01JD18AVT8PHWC5YRH6EERNW2N';
        $gamePlayerId = '01jjyq12j4391yv97qvt0sh49r';

        $this->expectException(DomainException::class);

        $this->expectExceptionMessage('Rate period has expired.');

        $decideMom->execute($gameId, $gamePlayerId);
    }

    public function test_MOMカウントが無い場合は決定できない(): void
    {
        // 現在時間を試合翌日にする
        Carbon::setTestNow('2024-08-25');

        // mom_countを最大(5)にする
        GameUser::forceCreate([
            'mom_count' => 5,
            'mom_game_player_id' => '01jjyq12j4391yv97qvt0sh49r',
            'user_id' => 1,
            'game_id' => '01JD18AVT8PHWC5YRH6EERNW2N'
        ]);

        $decideMom = app(DecideMom::class);

        $gameId = '01JD18AVT8PHWC5YRH6EERNW2N';
        $gamePlayerId = '01jjyq12j4391yv97qvt0sh49r';

        $this->expectException(DomainException::class);

        $this->expectExceptionMessage('MOM limit exceeded.');

        $decideMom->execute($gameId, $gamePlayerId);
    }
}
