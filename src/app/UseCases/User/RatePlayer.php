<?php declare(strict_types=1);

namespace App\UseCases\User;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Rating;
use App\UseCases\User\PlayerRateRules;
use App\UseCases\User\DomainException;


class RatePlayer
{
    public function __construct(private PlayerRateRules $playerRateRules)
    {
        
    }
    
    /**
     * @param  string $gameId
     * @param  string $gamePlayerId
     * @param  float $rating
     */
    public function execute(string $gameId, string $gamePlayerId, float $rating)
    {
        try {
            $game = Game::query()
                ->with([
                    'gameUser:game_id,mom_count',
                    'gamePlayers' => fn ($query) => $query
                        ->with('myRating')
                        ->where('id', $gamePlayerId)
                ])
                ->select(['id', 'date'])
                ->find($gameId);

            if (!$game) {
                throw new ModelNotFoundException('Game Not Found');
            }

            /** @var GamePlayer $gamePlayer */
            $gamePlayer = $game->gamePlayers->first();

            if (!$gamePlayer) {
                throw new ModelNotFoundException('GamePlayer Not Found');
            }

            if ($this->playerRateRules->isRateExceeded($game)) {
                throw new DomainException($this->playerRateRules::RATE_PERIOD_EXPIRED_MESSAGE);
            }

            if ($this->playerRateRules->canRate($gamePlayer)) {
                throw new DomainException($this->playerRateRules::RATE_LIMIT_EXCEEDED_MESSAGE);
            }

            /** @var Rating $myRating */
            $myRating = $gamePlayer->myRating
                ?? new Rating([
                    'game_player_id' => $gamePlayerId,
                    'user_id' => 1,
                    'rating' => $rating
                ]);

            $myRating->rate_count++;

            DB::transaction(function () use ($myRating) {
                $myRating->save();
            });

        } catch (ModelNotFoundException $e) {
            throw $e;

        } catch (DomainException $e) {
            throw $e;
            
        } catch (Exception $e) {
            throw $e;
        }
    }
}