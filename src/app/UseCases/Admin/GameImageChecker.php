<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use Illuminate\Support\Collection;

use App\Events\LeagueImagesRegisterRequested;
use App\Events\PlayerImagesRegisterRequested;
use App\Events\TeamImagesRegisterRequested;
use App\UseCases\Admin\GameDetail\GameDetail;
use App\UseCases\Admin\GameDetail\GameDetailList;
use File\LeagueImageFile;
use File\PlayerImageFile;
use File\TeamImageFile;


class GameImageChecker
{
    private LeagueImageFile $leagueImageFile;
    private TeamImageFile $teamImageFile;
    private PlayerImageFile $playerImageFile;
    
    private Collection $leagueIds;
    private Collection $teamIds;
    private Collection $playerIds;

    public function __construct()
    {
        $this->leagueImageFile = new LeagueImageFile;
        $this->teamImageFile   = new TeamImageFile;
        $this->playerImageFile = new PlayerImageFile;
    }
    
    public function fromGames(GameDetailList $games)
    {
        $this->leagueIds = $games->leagueIds();
        $this->teamIds   = $games->teamIds();
        $this->playerIds = collect();

        return $this;
    }

    public function fromGame(GameDetail $game)
    {
        $this->leagueIds = $game->getLeagueId();
        $this->teamIds   = $game->getTeamIds();
        $this->playerIds = $game->getPlayerIds();
        
        return $this;
    }

    public function dispatch(): void
    {
        $invalidLeagueImages = $this->invalidLeagueImages();
        $invalidTeamImages   = $this->invalidTeamImages();
        
        
        LeagueImagesRegisterRequested::dispatchIf($invalidLeagueImages->isNotEmpty(), $invalidLeagueImages);
        TeamImagesRegisterRequested::dispatchIf($invalidTeamImages->isNotEmpty(), $invalidTeamImages);

        if ($this->playerIds->isEmpty()) return;
        
        $invalidPlayerImages = $this->invalidPlayerImages();
        PlayerImagesRegisterRequested::dispatchIf($invalidPlayerImages->isNotEmpty(), $invalidPlayerImages);
    }

    private function invalidLeagueImages()
    {
        return $this->leagueIds->filter(fn(int $leagueId) => !$this->leagueImageFile->exist($leagueId));
    }

    private function invalidTeamImages()
    {
        return $this->teamIds->filter(fn(int $teamId) => !$this->teamImageFile->exist($teamId));
    }

    private function invalidPlayerImages()
    {
        return $this->playerIds->filter(fn(int $playerId) => !$this->playerImageFile->exist($playerId));
    }
}