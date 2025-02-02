<?php declare(strict_types=1);

namespace Tests\Unit\User\UseCases;

use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\GameUser;
use App\UseCases\User\PlayerRateRules;
use Illuminate\Support\Carbon;
use Tests\TestCase;


class PlayerRateRulesTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow('2024-11-11 00:00:00');
    }

    public function test_レーティングが3以上10以下ならtrueを返す()
    {
        $rule = app(PlayerRateRules::class);

        $this->assertTrue($rule->isInRange(3.0));
        $this->assertTrue($rule->isInRange(10.0));
    }

    public function test_レーティングが3未満10より大きいならfalseを返す()
    {
        $rule = app(PlayerRateRules::class);

        $this->assertFalse($rule->isInRange(2.9));
        $this->assertFalse($rule->isInRange(10.1));
    }

    public function test_評価期間内ならfalseを返す()
    {
        $rule = app(PlayerRateRules::class);

        $game = new Game();
        $game->finished_at = '2024-11-06 00:00:01';

        $this->assertFalse($rule->isRateExpired($game));
    }

    public function test_評価期間外ならtrueを返す()
    {
        $rule = app(PlayerRateRules::class);

        $game = new Game();
        $game->finished_at = '2024-11-06 00:00:00';

        $this->assertTrue($rule->isRateExpired($game));
    }

    public function test_MOMの上限内ならtrueを返す()
    {
        $rule = app(PlayerRateRules::class);

        $gameUser = new GameUser();
        $gameUser->mom_count = 4;

        $this->assertTrue($rule->canDecideMOM($gameUser));
    }

    public function test_MOMの上限以上ならfalseを返す()
    {
        $rule = app(PlayerRateRules::class);

        $gameUser = new GameUser();
        $gameUser->mom_count = 5;

        $this->assertFalse($rule->canDecideMOM($gameUser));
    }

    public function test_RateCountの上限内ならtrueを返す()
    {
        $rule = app(PlayerRateRules::class);

        $gamePlayer = new GamePlayer();
        $gamePlayer->myRating->rate_count = 2;

        $this->assertTrue($rule->canRate($gamePlayer));
    }

    public function test_RateCountの上限以上ならfalseを返す()
    {
        $rule = app(PlayerRateRules::class);

        $gamePlayer = new GamePlayer();
        $gamePlayer->myRating->rate_count = 3;

        $this->assertFalse($rule->canRate($gamePlayer));
    }
}
