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
    public function __construct(private PlayerRateRules $rateRule)
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
            if (!$this->rateRule->isInRange($rating)) {
                throw new DomainException($this->rateRule::OUT_OF_RANGE_MESSAGE);
            }
            
            $game = Game::query()
                ->with([
                    'gameUser:game_id,mom_count',
                    'gamePlayers' => fn ($query) => $query
                        ->select(['id', 'game_id'])
                        ->with('myRating')
                        ->where('id', $gamePlayerId)
                ])
                ->select(['id', 'started_at', 'finished_at'])
                ->find($gameId);

            if (!$game) {
                throw new ModelNotFoundException('Game Not Found');
            }

            /** @var GamePlayer $gamePlayer */
            $gamePlayer = $game->gamePlayers->first();

            if (!$gamePlayer) {
                throw new ModelNotFoundException('GamePlayer Not Found');
            }

            if ($this->rateRule->isRateExpired($game)) {
                throw new DomainException($this->rateRule::RATE_PERIOD_EXPIRED_MESSAGE);
            }

            if (!$this->rateRule->canRate($gamePlayer)) {
                throw new DomainException($this->rateRule::RATE_LIMIT_EXCEEDED_MESSAGE);
            }
            
            /** @var Rating $myRating */
            $myRating = $gamePlayer->myRating;

            $myRating->rate_count++;
            $myRating->rating = $rating;

            /** @var GameUser $gameUser */
            $gameUser = $game->gameUser;
            $gameUser->is_rated = true;

            DB::transaction(function () use ($myRating, $gamePlayer, $gameUser) {
                $gamePlayer
                    ->myRating()
                    ->save($myRating);

                $gameUser->save();
            });
            
            $newGamePlayer = $gamePlayer->refresh()->load('myRating');
            
            return [
                'id'        => $gamePlayer->id,
                'canRate'   => $this->rateRule->canRate($newGamePlayer),
                'rateCount' => $newGamePlayer->myRating->rate_count,
                'myRating'  => $newGamePlayer->myRating->rating,
            ];

        } catch (ModelNotFoundException $e) {
            throw $e;

        } catch (DomainException $e) {
            throw $e;
            
        } catch (Exception $e) {
            throw $e;
        }
    }
}