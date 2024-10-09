<?php declare(strict_types=1);

namespace App\Infrastructure\FlashLive;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

use App\UseCases\Admin\GameDetail\FlashPlayer;
use App\UseCases\Admin\FlashLiveRepositoryInterface;
use App\UseCases\Admin\GameDetail\PlayerImage;
use File\FlashPlayerFile;

class FlashLiveRepository implements FlashLiveRepositoryInterface
{
    public function __construct(private FlashPlayerFile $flashPlayerFile)
    {
        
    }
    
    private function httpClient(string $url, ?array $queryParams = null): string
    {
        try {
            $response = Http::withHeaders([
                'X-RapidAPI-Host' => config('flash-live-sports.api-host'),
                'X-RapidAPI-Key'  => config('flash-live-sports.api-key')
            ])
            ->retry(1, 500)
            ->get($url, $queryParams);
    
            return $response->throw()->body();
        } catch (Exception $e) {
            dd($e);
        }
    }

    // public function fetchSquad(): PlayerInfos
    // {
    //     if ($this->teamSquadFile->exists()) {
    //         return PlayerInfos::fromFlashSquad(FlashSquad::create($this->teamSquadFile->get()));
    //     }
        
    //     $json = $this->httpClient('https://flashlive-sports.p.rapidapi.com/v1/teams/squad', [
    //             'sport_id' => config('flash-live-sports.sport-id'),
    //             'team_id'  => config('flash-live-sports.chelsea-id'),
    //             'locale'   => config('flash-live-sports.locale')
    //         ]);
            
    //     $data = collect(json_decode($json)->DATA);

    //     $this->teamSquadFile->write($data);
        
    //     return PlayerInfos::fromFlashSquad(FlashSquad::create($data));
    // }

    // public function fetchPlayer(PlayerInfo $playerInfo): FlashPlayer
    // {
    //     // if ($this->isTest()) {
    //     //     return FlashPlayer::fromPlayer($this->playerFile->get($player->getFlashId()));
    //     // }

    //     // if ($this->isSeed()) {
    //     //     if ($this->playerFile->exists($player->getFlashId())) {
    //     //         return FlashPlayer::fromPlayer($this->playerFile->get($player->getFlashId()));
    //     //     }

    //     //     dd('not exists');
    //     // }

    //     // if ($this->playerFile->exists($player->getFlashId())) {
    //     //     return FlashPlayer::fromPlayer($this->playerFile->get($player->getFlashId()));
    //     // }
        
    //     // $json = $this->httpClient('https://flashlive-sports.p.rapidapi.com/v1/players/data', [
    //     //         'player_id' => $player->getFlashId(),
    //     //         'sport_id'  => config('flash-live-sports.sport-id'),
    //     //         'locale'    => config('flash-live-sports.locale')
    //     //     ]);
            
    //     // $data = collect(json_decode($json)->DATA);

    //     // $this->playerFile->write($player->getFlashId(), $data);
        
    //     // return FlashPlayer::fromPlayer($data);
    // }

    public function searchPlayer(Collection $player): FlashPlayer
    {
        // $json = $this->httpClient('https://flashlive-sports.p.rapidapi.com/v1/search/multi-search', [
        //     'locale' => config('flash-live-sports.locale'),
        //     'query'  => $player['name']
        // ]);

        // $data = collect(json_decode($json, true));

        $data = $this->flashPlayerFile->get($player['api_player_id']);

        return FlashPlayer::fromPlayers($data, $player['name']);
    }
    
    /**
     * 選手の画像を取得する
     *
     * @param  Collection<{api_player_id: int, flash_image_id: string}> $player
     * @return PlayerImage
     */
    public function fetchPlayerImage(Collection $player): PlayerImage
    {
        $playerImage = $this->httpClient('https://flashlive-sports.p.rapidapi.com/v1/images/data', [
            'image_id'=> $player['flash_image_id']
        ]);
        
        return new PlayerImage($player['api_player_id'], $playerImage);
    }
}