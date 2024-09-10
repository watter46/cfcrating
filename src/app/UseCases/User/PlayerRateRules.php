<?php declare(strict_types=1);

namespace App\UseCases\User;

use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\GameUser;
use Illuminate\Support\Carbon;

class PlayerRateRules
{
    /** 評価可能期間 5日間 */
    private const RATE_PERIOD_HOURS = 24 * 5;
    public const RATE_PERIOD_EXPIRED_MESSAGE = 'Rate period has expired.';

    /** レーティング評価可能回数 */
    private const RATE_LIMIT = 3;
    public const RATE_LIMIT_EXCEEDED_MESSAGE = 'Rate limit exceeded.';

    /** MOM評価可能回数 */
    private const MOM_LIMIT = 5;
    public const MOM_LIMIT_EXCEEDED_MESSAGE = 'MOM limit exceeded.';


    public function isRateExceeded(Game $game): bool
    {
        $specifiedDate = Carbon::parse($game->date);
        
        return $specifiedDate->diffInHours(now('UTC')) >= self::RATE_PERIOD_HOURS;
    }

    public function canRate(GamePlayer $gamePlayer): bool
    {
        if (!isset($gamePlayer->myRating)) {
            return true;
        }
        
        if ($gamePlayer->myRating->rate_count < self::RATE_LIMIT) {
            return true;
        }

        return false;
    }

    public function canDecideMOM(GameUser $gameUser)
    {
        if ($gameUser->mom_count < self::MOM_LIMIT) {
            return true;
        }

        return false;
    }
}