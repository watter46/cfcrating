<?php declare(strict_types=1);

namespace App\UseCases\Admin\Game;

use Illuminate\Support\Carbon;

use App\Models\Game;


class AverageRatingUpdateRules
{
    public const RATING_PERIOD_DAYS = 3;

    private const INITIAL_UPDATE_WINDOW_HOURS = 3;
    private const INITIAL_INTERVAL_MINUTES = 15;
    private const SUBSEQUENT_INTERVAL_MINUTES = 60;

    /**
     * 試合終了後3時間は15分おきに更新
     * その後は1時間おきに更新する
     * 
     * 時間に基づいてAverage Ratingを更新するか判定する
     *
     * @return boolean
     */
    public function shouldUpdate()
    {
        $games = Game::query()
            ->currentSeason()
            ->withinDays()
            ->get(['finished_at', 'updated_at']);

        if ($games->isEmpty()) {
            return false;
        }

        return $games
            ->some(function ($game) {
                $finishedAt = $game['finished_at'];
                $updatedAt = $game['updated_at'];

                return $this->hasElapsedSinceLastUpdate($finishedAt, $updatedAt);
            });
    }

    public function gameIdsToUpdate()
    {
        $games = Game::query()
            ->currentSeason()
            ->withinDays()
            ->get(['id', 'finished_at', 'updated_at']);

        return $games
            ->filter(function ($game) {
                $finishedAt = $game['finished_at'];
                $updatedAt = $game['updated_at'];

                return $this->hasElapsedSinceLastUpdate($finishedAt, $updatedAt);
            })
            ->pluck('id');
    }

    private function hasElapsedSinceLastUpdate(Carbon|string $finished_at, Carbon|string|null $lastUpdated_at)
    {
        if (is_null($lastUpdated_at)) {
            $finishedAt = is_string($finished_at)
                ? Carbon::parse($finished_at)
                : $finished_at;

            return abs(now('UTC')->diffInUTCMinutes($finishedAt)) >= self::INITIAL_INTERVAL_MINUTES;
        }

        $lastUpdatedAt = is_string($lastUpdated_at)
            ? Carbon::parse($lastUpdated_at)
            : $lastUpdated_at;
            
        $interval = $this->isInitialUpdateWindow($finished_at)
            ? self::INITIAL_INTERVAL_MINUTES
            : self::SUBSEQUENT_INTERVAL_MINUTES; 
            
        return abs(now('UTC')->diffInMinutes($lastUpdatedAt)) > $interval;
    }

    private function isInitialUpdateWindow(Carbon|string $finished_at)
    {
        $finishedAt = is_string($finished_at)
            ? Carbon::parse($finished_at)
            : $finished_at;

        return abs(now('UTC')->diffInHours($finishedAt)) <= self::INITIAL_UPDATE_WINDOW_HOURS;
    }
}