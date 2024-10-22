<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball;

use Illuminate\Support\Collection;


class Fixtures
{    
    /**
     * __construct
     *
     * @param  Collection<Fixture> $fixtures
     * @return void
     */
    public function __construct(private Collection $fixtures)
    {
        
    }
    
    public static function create(Collection $data)
    {
        return new self(
            $data->map(fn(Collection $fixture) => Fixture::create($fixture))
        );
    }

    public function asCollection()
    {
        return $this->fixtures
            ->map(function (Fixture $fixture) {
                return collect([
                    'fixture_id' => $fixture->fixtureId(),
                    'league_id' => $fixture->getLeagueId(),
                    'season' => $fixture->getSeason(),
                    'date' => $fixture->getDate(),
                    'is_end' => $fixture->getIsEnd(),
                    'score' => $fixture->getScore(),
                    'teams' => $fixture->getTeams(),
                    'league' => $fixture->getLeague(),
                ]);
            });
    }

    public function getLeagueIds()
    {
        return $this->fixtures
            ->map(fn(Fixture $fixture) => $fixture->getLeagueId());
    }

    public function getTeamIds()
    {
        return $this->fixtures
            ->map(fn(Fixture $fixture) => $fixture->getTeamIds());
    }

    public function getPlayerIds()
    {
        return $this->fixtures
            ->map(fn(Fixture $fixture) => $fixture->getPlayerIds());
    }
}