<?php declare(strict_types=1);

namespace App\Http\Livewire\User\Game;

use Exception;
use Livewire\Component;

use App\Http\Livewire\Util\MessageType;
use App\UseCases\User\DecideMom;
use App\UseCases\User\RatePlayer;


class Player extends Component
{
    public string $name;
    public string $size;

    public array $player;

    private readonly RatePlayer $ratePlayer;
    private readonly PlayerPresenter   $presenter;
    private readonly DecideMom $decideMom;

    private const RATED_MESSAGE = 'Rated!!';
    private const Decided_MOM_MESSAGE = 'Decided MOM!!';

    use PlayerTrait;

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

            $this->dispatch('player-rated.'.$player['id'], $player);
            $this->dispatch('notify', message: MessageType::Success->toArray(self::RATED_MESSAGE));
            $this->dispatch('close');

        } catch (Exception $e) {
            $this->dispatch('notify', message: MessageType::Error->toArray($e->getMessage()));
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

            $this->dispatch('mom-decided', $momPlayer);
            $this->dispatch('notify', message: MessageType::Success->toArray(self::Decided_MOM_MESSAGE));
            $this->dispatch('close');

        } catch (Exception $e) {
            $this->dispatch('notify', message: MessageType::Error->toArray($e->getMessage()));
        }
    }
}