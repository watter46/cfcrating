<?php declare(strict_types=1);

namespace App\Http\Livewire\User\Rating;

use Exception;
use Livewire\Component;

use App\UseCases\User\DecideMom;
use App\UseCases\User\RatePlayer;
use App\Http\Livewire\User\Rating\RatingPresenter;
use App\Http\Livewire\User\Rating\RatingDispatcher;


class RatingEditor extends Component
{
    use RatingDispatcher;
    
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

            $this->dispatchUpdateMom($momPlayer);

        } catch (Exception $e) {
            $this->dispatchError($e->getMessage());
        }
    }
}