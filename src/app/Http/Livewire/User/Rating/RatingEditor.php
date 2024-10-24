<?php declare(strict_types=1);

namespace App\Http\Livewire\User\Rating;

use Exception;
use Livewire\Component;

use App\UseCases\User\DecideMom;
use App\UseCases\User\RatePlayer;
use App\Http\Livewire\User\Rating\RatingPresenter;
use App\Http\Livewire\User\Rating\RatingDispatcher;
use App\Http\Livewire\Util\MessageDispatcher;
use App\Http\Livewire\Util\ModalDispatcher;


class RatingEditor extends Component
{
    use RatingDispatcher;
    use MessageDispatcher;
    use ModalDispatcher;
    
    public array $player;

    private readonly RatePlayer $ratePlayer;
    private readonly DecideMom $decideMom;
    private readonly RatingPresenter $presenter;

    public function boot(
        RatePlayer $ratePlayer,
        DecideMom $decideMom,
        RatingPresenter $presenter
    ) {
        $this->decideMom  = $decideMom;
        $this->ratePlayer = $ratePlayer;
        $this->presenter  = $presenter;
    }
    
    public function render()
    {
        return view('livewire.user.rating.rating-editor',
            $this->presenter->getRatingRanges($this->player)
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

            $this->dispatchUpdateRating($player);

            $this->notifySuccess(self::RATED_MESSAGE);
            $this->closeModal('player-'.$player['id']);

        } catch (Exception $e) {
            $this->notifyError($e->getMessage());
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
            $player = $this->decideMom->execute(
                    $this->player['gameId'],
                    $this->player['id']
                );

            $this->dispatchUpdateMom($player);

            $this->notifySuccess(self::Decided_MOM_MESSAGE);
            $this->closeModal('player-'.$player['id']);

        } catch (Exception $e) {
            $this->notifyError($e->getMessage());
        }
    }
}