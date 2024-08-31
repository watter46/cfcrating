<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameDetail;

use Illuminate\Support\Collection;

use App\Models\Game as GameModel;


interface GameDetailFactoryInterface
{
    public function create(Collection $raw_game_detail): GameDetail;
    public function reconstruct(GameModel $game_model): GameDetail;
}