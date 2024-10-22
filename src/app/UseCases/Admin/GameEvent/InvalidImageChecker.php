<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameEvent;

use Illuminate\Support\Collection;

use App\File\Image\LeagueImageFile;
use App\File\Image\PlayerImageFile;
use App\File\Image\TeamImageFile;


class InvalidImageChecker
{
    private LeagueImageFile $leagueImageFile;
    private TeamImageFile $teamImageFile;
    private PlayerImageFile $playerImageFile;

    /** @var Collection<int> $invalidLeagueIds */
    public Collection $invalidLeagueIds;

    /** @var Collection<int> $invalidTeamIds */
    public Collection $invalidTeamIds;

    /** @var Collection<int> $invalidPlayerIds */
    public Collection $invalidPlayerIds;
        
    /**
     * __construct
     * @param Collection<int> $leagueIds
     * @param Collection<int> $teamIds
     * @param Collection<int> $playerIds
     * @return void
     */
    public function __construct(
        Collection $leagueIds,
        Collection $teamIds,
        Collection $playerIds = new Collection
    ) {
        $this->leagueImageFile = new LeagueImageFile;
        $this->teamImageFile   = new TeamImageFile;
        $this->playerImageFile = new PlayerImageFile;

        $this->invalidLeagueIds = $this->filterLeagueImages($leagueIds);
        $this->invalidTeamIds   = $this->filterTeamImages($teamIds);
        $this->invalidPlayerIds = $this->filterPlayerImages($playerIds);
    }

    private function filterLeagueImages(Collection $leagueIds)
    {
        return $leagueIds->filter(fn(int $leagueId) => !$this->leagueImageFile->exist($leagueId));
    }

    private function filterTeamImages(Collection $teamIds)
    {
        return $teamIds->filter(fn(int $teamId) => !$this->teamImageFile->exist($teamId));
    }

    private function filterPlayerImages(Collection $playerIds)
    {
        return $playerIds->filter(fn(int $playerId) => !$this->playerImageFile->exist($playerId));
    }
}