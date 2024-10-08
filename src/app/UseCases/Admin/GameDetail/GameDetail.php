<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameDetail;

use App\Domain\Game\FixtureId;
use App\Domain\Game\GameId;
use App\Domain\Game\TeamId;
use App\UseCases\Admin\GameDetail\Teams;
use App\UseCases\Admin\GameDetail\Score;
use App\UseCases\Admin\GameDetail\League;
use App\UseCases\Admin\GameDetail\Fixture;


class GameDetail
{
    private function __construct(
        private readonly GameId $gameId,
        private readonly FixtureId $fixtureId,
        private ?Teams $teams,
        private ?Score $score,
        private ?League $league,
        private ?Fixture $fixture,
        private ?Lineups $lineups
    ) {
        
    }

    public static function create(
        GameId $gameId,
        FixtureId $fixtureId,
        ?Teams $teams = null,
        ?Score $score = null,
        ?League $league = null,
        ?Fixture $fixture = null,
        ?Lineups $lineups = null
    ): self {
        return new self(
            $gameId,
            $fixtureId,
            $teams,
            $score,
            $league,
            $fixture,
            $lineups
        );
    }

    public function getGameId()
    {
        return $this->gameId;
    }

    public function toFill(): array
    {
        return [
            'season' => $this->fixture->getSeason(),
            'date' => $this->fixture->getDate(),
            'is_end' => $this->fixture->getIsEnd(),
            'score' => $this->score->toJson(),
            'teams' => $this->teams->toJson(),
            'league' => $this->league->toJson()
        ];
    }

    public function toUpsert()
    {
        return [
            'id' => $this->gameId->get(),
            'fixture_id' => $this->fixtureId->get(),
            'league_id' => $this->getLeagueId()->first(),
            'season' => $this->fixture->getSeason(),
            'date' => $this->fixture->getDate(),
            'is_end' => $this->fixture->getIsEnd(),
            'score' => $this->score->toCollect(),
            'teams' => $this->teams->toCollect(),
            'league' => $this->league->toCollect()
        ];
    }

    public function getLineups()
    {
        return $this->lineups;
    }

    public function equalByFixtureId(FixtureId $fixtureId)
    {
        return $this->fixtureId->equal($fixtureId);
    }

    public function fixtureId()
    {
        return $this->fixtureId;
    }

    public function update(GameDetail $newGameDetail)
    {
        return new self(
            $this->gameId,
            $this->fixtureId,
            ...$newGameDetail->newDetail()
        );
    }

    public function newDetail()
    {
        return [$this->teams, $this->score, $this->league, $this->fixture, $this->lineups];
    }

    public function getTeamIds()
    {
        return $this->teams
            ->teamIds()
            ->map(fn(TeamId $teamId) => $teamId->get());
    }

    public function getLeagueId()
    {
        return collect($this->league
            ->leagueId()
            ->get());
    }

    public function getPlayerIds()
    {
        return $this->lineups->getPlayerIds();
    }
}