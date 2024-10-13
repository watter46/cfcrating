<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball\ModelBuilder;

use Illuminate\Support\Collection;

use App\UseCases\Admin\Api\ApiFootball\Fixture;


class GameBuilder
{    
    /**
     * fromFixtures
     *
     * @param  Collection<Fixture> $fixtures
     * @return array
     */
    public function fromFixtures(Collection $fixtures): array
    {
        return [

        ];
    }

    /**
     * fromFixtures
     *
     * @param  Fixture $fixture
     * @return array
     */
    public function fromFixture(Fixture $fixture): array
    {
        return [
            'season' => $fixture->getSeason(),
            'date' => $fixture->getDate(),
            'is_end' => $fixture->getIsEnd(),
            'score' => $fixture->getScore(),
            'teams' => $fixture->getTeams(),
            'league' => $fixture->getLeague(),
            'is_details_fetched' => true
        ];
    }
}