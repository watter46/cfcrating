<?php declare(strict_types=1);

namespace App\UseCases\User;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Game;
use App\Models\GamePlayer;
use App\UseCases\User\PlayerRateRules;


class DecideMom
{
    public function __construct(private PlayerRateRules $playerRateRules)
    {
        
    }
    
    /**
     * @param  string $gameId
     * @param  string $gamePlayerId
     */
    public function execute(string $gameId, string $gamePlayerId)
    {
        try {
            $game = Game::query()
                ->with('gameUser')
                ->select(['id', 'date'])
                ->find($gameId);

            if (!$game) {
                throw new ModelNotFoundException('Game Not Found');
            }

            if ($this->playerRateRules->isRateExpired($game)) {
                throw new DomainException($this->playerRateRules::RATE_PERIOD_EXPIRED_MESSAGE);
            }

            if (!$this->playerRateRules->canDecideMOM($game->gameUser)) {
                throw new DomainException($this->playerRateRules::MOM_LIMIT_EXCEEDED_MESSAGE);
            }

            /** @var GamePlayer $gamePlayer */
            $gamePlayer = GamePlayer::where('id', $gamePlayerId)->exists();

            if (!$gamePlayer) {
                throw new ModelNotFoundException('Player Not Found');
            }
            
            /** @var GameUser $gameUser */
            $gameUser = $game->gameUser;

            if (!$gameUser) {
                throw new ModelNotFoundException('GameUser Not Found');
            }

            $gameUser->mom_count++;
            $gameUser->mom_game_player_id = $gamePlayerId;

            DB::transaction(function () use ($gameUser) {
                $gameUser->save();
            });

            $newGameUser = $gameUser->refresh();

            return [
                'id'       => $gamePlayerId,
                'canMom'   => $this->playerRateRules->canDecideMOM($newGameUser),
                'momCount' => $newGameUser->mom_count
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