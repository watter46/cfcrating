<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball\ModelBuilder;

use Illuminate\Support\Collection;

use App\UseCases\Admin\Api\ApiFootball\Fixtures;
use App\UseCases\Admin\Api\ApiFootball\Fixture;


class GameBuilder
{
    private const int FETCH_DELAY_MINUTES = 110;

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
            ->getFixtures()
            ->map(function (Fixture $fixture) use ($gameByFixtureId) {
                $game = $gameByFixtureId->get($fixture->getFixtureId());

                if (!$game) {
                    return array_merge($this->toModelData($fixture), ['is_details_fetched' => false]);
                }

                return array_merge(
                        $this->toModelData($fixture), [
                        'id' => $game->get('id'),
                        'is_details_fetched' => $game->get('is_details_fetched')
                    ]);
            })
            ->pipe(function (Collection $fixtures) {
                return Collection::unwrap($fixtures);
            });
    }

    /**
     * fromFixture
     *
     * @param  Fixture $fixture
     * @return array
     */
    public function fromFixture(Fixture $fixture): array
    {
        return array_merge($this->toModelData($fixture), ['is_details_fetched' => true]);
    }

    private function toModelData(Fixture $fixture): array
    {
        return [
            'fixture_id' => $fixture->getFixtureId(),
            'league_id' => $fixture->getLeagueId(),
            'season' => $fixture->getSeason(),
            'score' => $fixture->getScore(),
            'teams' => $fixture->getTeams(),
            'league' => $fixture->getLeague(),
            'started_at' => $fixture->getDate(),
            'finished_at' => $fixture->getDate()->addMinutes(self::FETCH_DELAY_MINUTES),
            'is_end' => $fixture->getIsEnd(),
            'is_winner' => $fixture->getIsWinner()
        ];
    }
}
