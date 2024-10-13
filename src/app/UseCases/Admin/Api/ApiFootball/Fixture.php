<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball;

use Illuminate\Support\Collection;

use App\UseCases\Admin\Api\ApiFootball\Teams;
use App\UseCases\Admin\Api\ApiFootball\Score;
use App\UseCases\Admin\Api\ApiFootball\League;
use App\UseCases\Admin\Api\ApiFootball\Info;
use Exception;

readonly class Fixture
{
    private function __construct(
        private Teams $teams,
        private Score $score,
        private League $league,
        private Info $info,
        private ?Lineups $lineups
    ) {
        
    }

    public static function create(Collection $data)
    {
        return new self(
            teams: Teams::create($data->getDot('teams')),
            score: Score::create($data->getDot('score')),
            league: League::create($data->getDot('league')),
            info: Info::create($data->getDot('fixture')),
            lineups: $data->hasAny(['lineups', 'statistics', 'players'])
                ? Lineups::create($data->only(['lineups', 'statistics', 'players']))
                : null
        );
    }

    public function getTeams()
    {
        return $this->teams->get();
    }

    public function getTeamIds()
    {
        return $this->teams->teamIds();
    }

    public function getScore()
    {
        return $this->score->get();
    }
    
    public function getLeague()
    {
        return $this->league->get();
    }

    public function getLeagueId()
    {
        return $this->league->leagueId();
    }

    public function getLineups()
    {
        if (!$this->lineups) {
            throw new Exception('Lineups is Null.');
        }

        return $this->lineups;
    }

    public function getPlayerIds()
    {
        if (!$this->lineups) {
            throw new Exception('Lineups is Null.');
        }

        return $this->lineups->getPlayerIds();
    }

    public function fixtureId()
    {
        return $this->info->fixtureId();
    }

    public function getSeason()
    {
        return $this->info->getSeason();
    }

    public function getDate()
    {
        return $this->info->getDate();
    }

    public function getIsEnd()
    {
        return $this->info->getIsEnd();
    }
}