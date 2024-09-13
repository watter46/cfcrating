<?php declare(strict_types=1);

namespace App\UseCases\User;

use App\Models\Game;
use App\Models\GamePlayer;
use App\UseCases\User\PlayerRateRules;


class GamePlayerValidator
{
    public function __construct(private PlayerRateRules $rule)
    {
        
    }

    public function validated(Game $game, GamePlayer $gamePlayer)
    {
        $isRateExpired = $this->rule->isRateExpired($game);
        $canRate = $this->rule->canRate($gamePlayer);
        $canMom  = $this->rule->canDecideMOM($game->gameUser);
        
        $gamePlayer->canRate = $canRate && !$isRateExpired;
        $gamePlayer->canMom  = $canMom && !$isRateExpired;
        $gamePlayer->rateLimit = $this->rule::RATE_LIMIT;
        $gamePlayer->momLimit  = $this->rule::MOM_LIMIT;

        return $gamePlayer;
    }
}