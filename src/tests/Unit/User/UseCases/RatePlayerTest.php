<?php

namespace Tests\Unit\User\UseCases;

use App\Models\Rating;
use App\UseCases\User\DomainException;
use App\UseCases\User\RatePlayer;
use Database\Seeders\Test\UserOneGameSeeder;
use Illuminate\Support\Carbon;
use Tests\Unit\User\UserTestCase;


class RatePlayerTest extends UserTestCase
{
    protected $seeder = UserOneGameSeeder::class;

    public function test_指定の選手を評価できる(): void
    {
        // 現在時間を試合翌日にする
        Carbon::setTestNow('2024-08-25');
        
        $ratePlayer = app(RatePlayer::class);

        $gameId = '01JD18AVT8PHWC5YRH6EERNW2N';
        $gamePlayerId = '01jd18avzkyr2bj21ardp1hnkx';
        
        $response = $ratePlayer->execute($gameId, $gamePlayerId, 10.0);

        $this->assertSame($gamePlayerId, $response['id']);
        $this->assertTrue($response['canRate']);
        $this->assertSame(1, $response['rateCount']);
        $this->assertSame(10.0, $response['myRating']);
    }

    public function test_評価カウントの上限になった場合はcanRateがfalseを返す(): void
    {
        // 現在時間を試合翌日にする
        Carbon::setTestNow('2024-08-25');

        Rating::forceCreate([
            'rating' => 10,
            'rate_count' => 2,
            'user_id' => 1,
            'game_player_id' => '01jd18avzkyr2bj21ardp1hnkx'
        ]);
        
        $ratePlayer = app(RatePlayer::class);

        $gameId = '01JD18AVT8PHWC5YRH6EERNW2N';
        $gamePlayerId = '01jd18avzkyr2bj21ardp1hnkx';

        $response = $ratePlayer->execute($gameId, $gamePlayerId, 10.0);

        $this->assertSame($gamePlayerId, $response['id']);
        $this->assertFalse($response['canRate']);
        $this->assertSame(3, $response['rateCount']);
        $this->assertSame(10.0, $response['myRating']);
    }

    public function test_レーティングが範囲外のとき評価できない()
    {
        // 現在時間を試合翌日にする
        Carbon::setTestNow('2024-08-25');
        
        $ratePlayer = app(RatePlayer::class);

        $gameId = '01JD18AVT8PHWC5YRH6EERNW2N';
        $gamePlayerId = '01jd18avzkyr2bj21ardp1hnkx';
        
        $this->expectException(DomainException::class);

        $this->expectExceptionMessage('rating must be between 3.0 and 10.0');
        
        $ratePlayer->execute($gameId, $gamePlayerId, 50);

        $this->expectException(DomainException::class);

        $this->expectExceptionMessage('rating must be between 3.0 and 10.0');
        
        $ratePlayer->execute($gameId, $gamePlayerId, -50);
    }

    public function test_評価可能期間外は評価ができない(): void
    {
        // 現在時間を期間外にする
        Carbon::setTestNow('2024-11-11');
        
        $ratePlayer = app(RatePlayer::class);

        $gameId = '01JD18AVT8PHWC5YRH6EERNW2N';
        $gamePlayerId = '01jd18avzkyr2bj21ardp1hnkx';
        
        $this->expectException(DomainException::class);

        $this->expectExceptionMessage('Rate period has expired.');
        
        $ratePlayer->execute($gameId, $gamePlayerId, 10.0);
    }

    public function test_評価カウントが無いとき評価できない(): void
    {
        // 現在時間を試合翌日にする
        Carbon::setTestNow('2024-08-25');
        
        // rate_countを最大(3)にする
        Rating::forceCreate([
            'rating' => 10,
            'rate_count' => 3,
            'user_id' => 1,
            'game_player_id' => '01jd18avzkyr2bj21ardp1hnkx'
        ]);
        
        $ratePlayer = app(RatePlayer::class);

        $gameId = '01JD18AVT8PHWC5YRH6EERNW2N';
        $gamePlayerId = '01jd18avzkyr2bj21ardp1hnkx';
        
        $this->expectException(DomainException::class);

        $this->expectExceptionMessage('Rate limit exceeded.');
        
        $ratePlayer->execute($gameId, $gamePlayerId, 10.0);
    }
}