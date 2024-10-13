<?php declare(strict_types=1);

namespace App\Infrastructure\ApiFootball;

use Exception;
use File\FixtureFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

use App\UseCases\Admin\GameDetail\GameDetailList;
use App\UseCases\Admin\GameDetail\GameDetail;

use App\Domain\Game\GameId;
use App\Domain\Game\Season;
use App\Infrastructure\Game\Admin\GameDetailFactory;
use App\Models\Game as GameModel;
use App\UseCases\Admin\Api\ApiFootball\ApiFootballRepositoryInterface;
use App\UseCases\Admin\Api\ApiFootball\Fixture;
use App\UseCases\Admin\GameDetail\LeagueImage;
use App\UseCases\Admin\GameDetail\TeamImage;


class ApiFootballRepository implements ApiFootballRepositoryInterface
{
    public function __construct(
        private FixtureFile $fixtureFile,
        private GameDetailFactory $gameDetailFactory
    ) {
        
    }

    private function httpClient(string $url, ?array $queryParams = null): string
    {
        try {
            $response = Http::withHeaders([
                'X-RapidAPI-Host' => config('api-football.api-host'),
                'X-RapidAPI-Key'  => config('api-football.api-key')
            ])
            ->retry(1, 500)
            ->get($url, $queryParams);
    
            return $response->throw()->body();

        } catch (Exception $e) {
            dd($e);
            throw $e;
        }
    }

    /**
     * fetchGames
     *
     * @return GameDetailList
     */
    public function fetchFixtures(): GameDetailList
    {
        $json = $this->httpClient('https://api-football-v1.p.rapidapi.com/v3/fixtures', [
            'season' => Season::current(),
            'team'   => config('api-football.chelsea-id')
        ]);

        $data = collect(json_decode($json, true)['response'])
            ->recursiveCollect()
            ->map(function (Collection $rawGameDetail) {
                return $this->gameDetailFactory->create($rawGameDetail);
            });

        return GameDetailList::create($data);
    }

    public function fetchFixture(int $fixtureId): Fixture
    {
        $fixtureData = $this->fixtureFile->get($fixtureId);

        return Fixture::create($fixtureData);
    }
    
    // public function fetchFixture(int $fixtureId): GameDetail
    // {
    //     $json = $this->httpClient('https://api-football-v1.p.rapidapi.com/v3/fixtures', [
    //         'id' => $fixtureId
    //     ]);

    //     $data = collect(json_decode($json, true)['response'][0])->recursiveCollect();

    //     $this->fixtureFile->write($fixtureId, $data);

    //     return $this->gameDetailFactory->create($data);
    // }

    // /**
    //  * fetchPlayers
    //  *
    //  */
    // public function fetchSquads()
    // {

    // }

    public function fetchLeagueImage(int $leagueId): LeagueImage
    {
        $image = 'league image'.$leagueId;

        dd('repository');
        
        return new LeagueImage($leagueId, $image);
    }

    public function fetchTeamImage(int $teamId): TeamImage
    {
        $image = 'team image'.$teamId;

        dd('repository');

        return new TeamImage($teamId, $image);
    }
}