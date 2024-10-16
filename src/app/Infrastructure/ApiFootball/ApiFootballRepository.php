<?php declare(strict_types=1);

namespace App\Infrastructure\ApiFootball;

use Exception;
use Illuminate\Support\Facades\Http;

use App\Models\Util\Season;
use App\UseCases\Admin\Api\ApiFootball\ApiFootballRepositoryInterface;
use App\UseCases\Admin\Api\ApiFootball\Fixture;
use App\UseCases\Admin\Api\ApiFootball\Fixtures;
use App\UseCases\Admin\Api\ApiFootball\LeagueImage;
use App\UseCases\Admin\Api\ApiFootball\TeamImage;
use App\File\Data\FixturesFile;
use App\File\Data\FixtureFile;


class ApiFootballRepository implements ApiFootballRepositoryInterface
{
    public function __construct(
        private FixtureFile $fixtureFile,
        private FixturesFile $fixturesFile
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
            throw $e;
        }
    }

    public function fetchFixtures(): Fixtures
    {
        $json = $this->httpClient('https://api-football-v1.p.rapidapi.com/v3/fixtures', [
            'season' => Season::current(),
            'team'   => config('api-football.chelsea-id')
        ]);

        $data = collect(json_decode($json, true)['response'])
            ->recursiveCollect();

        $this->fixturesFile->write(Season::current(), $data);
        
        return Fixtures::create($data);
    }

    public function fetchFixture(int $fixtureId): Fixture
    {
        $json = $this->httpClient('https://api-football-v1.p.rapidapi.com/v3/fixtures', [
            'id' => $fixtureId
        ]);

        $data = collect(json_decode($json, true)['response'][0])->recursiveCollect();

        $this->fixtureFile->write($fixtureId, $data);

        return Fixture::create($data);
    }

    public function fetchLeagueImage(int $leagueId): LeagueImage
    {
        $image = $this->httpClient("https://media-4.api-sports.io/football/leagues/$leagueId.png");
        
        return new LeagueImage($leagueId, $image);
    }

    public function fetchTeamImage(int $teamId): TeamImage
    {
        $image = $this->httpClient("https://media-4.api-sports.io/football/teams/$teamId.png");

        return new TeamImage($teamId, $image);
    }
}