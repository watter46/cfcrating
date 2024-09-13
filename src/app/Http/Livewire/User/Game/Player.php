<?php declare(strict_types=1);

namespace App\Http\Livewire\User\Game;

use Exception;
use Livewire\Component;

use App\UseCases\User\DecideMom;
use App\UseCases\User\RatePlayer;
use App\Http\Livewire\User\Game\PlayerDispatcher;


class Player extends Component
{
    public string $name;
    public string $size;

    public array $player;

    private readonly RatePlayer $ratePlayer;
    private readonly PlayerPresenter   $presenter;
    private readonly DecideMom $decideMom;

    use PlayerDispatcher;

    public function boot(
        RatePlayer $ratePlayer,
        DecideMom $decideMom,
        PlayerPresenter $presenter
    ) {
        $this->decideMom  = $decideMom;
        $this->ratePlayer = $ratePlayer;
        $this->presenter  = $presenter;
    }

    public function render()
    {
        return view(
            'livewire.user.game.player',
            $this->presenter->getRatingRanges($this->player),
        );
    }

    /**
     * 選手のレートを評価する
     *
     * @param  float $rating
     * @return void
     */
    public function rate(float $rating): void
    {
        try {
            $player = $this->ratePlayer->execute(
                    $this->player['gameId'],
                    $this->player['id'],
                    $rating
                );

            $this->dispatchPlayerRated($player);

        } catch (Exception $e) {
            $this->dispatchError($e->getMessage());
        }
    }

    /**
     * ManOfTheMatchを決める
     *
     * @return void
     */
    public function decideMom(): void
    {
        try {
            $momPlayer = $this->decideMom->execute(
                    $this->player['gameId'],
                    $this->player['id']
                );

            $this->dispatchMomDecided($momPlayer);

        } catch (Exception $e) {
            $this->dispatchError($e->getMessage());
        }
    }
}