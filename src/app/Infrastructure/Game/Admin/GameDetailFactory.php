<?php declare(strict_types=1);

namespace App\Infrastructure\Game\Admin;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use App\UseCases\Admin\GameDetail\Fixture;
use App\UseCases\Admin\GameDetail\GameDetail;
use App\UseCases\Admin\GameDetail\League;
use App\UseCases\Admin\GameDetail\Score;
use App\UseCases\Admin\GameDetail\Teams;
use App\UseCases\Admin\GameDetail\Lineups;
use App\Domain\Game\GameId;
use App\Domain\Game\FixtureId;
use App\Models\Game;


class GameDetailFactory
{
    public function create(Collection $rawGameDetail): GameDetail
    {
        return GameDetail::create(
            GameId::create((string) Str::ulid()),
            FixtureId::create($rawGameDetail->getDotRaw('fixture.id')),
            Teams::create($rawGameDetail->getDot('teams')),
            Score::create($rawGameDetail->getDot('score')),
            League::create($rawGameDetail->getDot('league')),
            Fixture::create($rawGameDetail->getDot('fixture')),
            Lineups::create($rawGameDetail->only(['lineups', 'statistics', 'players']))
        );
    }

    public function reconstruct(Game $game_model): GameDetail
    {
        return GameDetail::create(
            GameId::create($game_model->id),
            FixtureId::create($game_model->fixture_id)
        );
    }
}