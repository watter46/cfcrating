<?php declare(strict_types=1);

namespace App\Infrastructure\FlashLive;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Exception;
use App\UseCases\Admin\Api\FlashLive\PlayerImage;
use App\UseCases\Admin\Api\FlashLive\FlashPlayerMatcher;
use App\UseCases\Admin\Api\FlashLive\FlashPlayer;
use App\UseCases\Admin\Api\FlashLive\FlashLiveRepositoryInterface;


class ProductionFlashLiveRepository implements FlashLiveRepositoryInterface
{
    private function httpClient(string $url, ?array $queryParams = null): string
    {
        try {
            $response = Http::withHeaders([
                'Cache-Control' => 'no-cache',
                'X-RapidAPI-Host' => config('flash-live-sports.api-host'),
                'X-RapidAPI-Key'  => config('flash-live-sports.api-key')
            ])
            ->retry(1, 500)
            ->get($url, $queryParams);

            return $response->throw()->body();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchPlayer(Collection $player): FlashPlayer
    {
        $json = $this->httpClient('https://flashlive-sports.p.rapidapi.com/v1/search/multi-search', [
            'locale' => config('flash-live-sports.locale'),
            'query'  => $player['name']
        ]);

        $data = collect(json_decode($json, true))->recursiveCollect();

        $matcher = new FlashPlayerMatcher($data, $player['name']);

        return $matcher->match();
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
