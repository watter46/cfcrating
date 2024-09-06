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
    public function create(Collection $raw_game_detail): GameDetail
    {
        return GameDetail::create(
            GameId::create((string) Str::ulid()),
            FixtureId::create($raw_game_detail->getDotRaw('fixture.id')),
            Teams::create($raw_game_detail->getDot('teams')),
            Score::create($raw_game_detail->getDot('score')),
            League::create($raw_game_detail->getDot('league')),
            Fixture::create($raw_game_detail->getDot('fixture')),
            Lineups::create($raw_game_detail->only(['lineups', 'statistics', 'players']))
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