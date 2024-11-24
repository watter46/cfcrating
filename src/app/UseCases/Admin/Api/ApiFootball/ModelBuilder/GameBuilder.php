<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball\ModelBuilder;

use Illuminate\Support\Collection;

use App\UseCases\Admin\Api\ApiFootball\Fixture;
use App\UseCases\Admin\Api\ApiFootball\Fixtures;


class GameBuilder
{    
    /**
     * fromFixtures
     *
     * @param  Fixtures $fixtures
     * @param  Collection<array{id:string,fixture_id:int}> $games
     * @return array
     */
    public function fromFixtures(Fixtures $fixtures, Collection $games): array
    {
        $gameByFixtureId = $games->keyBy('fixture_id');
        
        return $fixtures
            ->asCollection()
            ->map(function (Collection $fixture) use ($gameByFixtureId) {
                $game = $gameByFixtureId->get($fixture->get('fixture_id'));

                if (!$game) {
                    return Collection::unwrap(
                        $fixture
                            ->merge([
                                'is_details_fetched' => false
                            ])
                    );
                }

                return Collection::unwrap(
                    $fixture
                        ->merge([
                            'id' => $game->get('id'),
                            'is_details_fetched' => $game->get('is_details_fetched')
                        ])
                );
            })
            ->pipe(function (Collection $fixtures) {
                return Collection::unwrap($fixtures);
            });
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
            'started_at' => $fixture->getDate(),
            'is_end' => $fixture->getIsEnd(),
            'score' => $fixture->getScore(),
            'teams' => $fixture->getTeams(),
            'league' => $fixture->getLeague(),
            'is_details_fetched' => true
        ];
    }
}