<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use Illuminate\Support\Carbon;

use App\Models\Game;


class GameFetchTimingService
{
    private const FETCH_DELAY_MINUTES = 115;
    private const RETRY_INTERVAL_MINUTES = 10;
    
    /**
     * 試合が終わってデータを取得するか判定する
     *
     * @param  string $gameId
     * @return bool
     */
    public function shouldFetch(string $gameId): bool
    {
        $game = Game::select(['is_end', 'date'])->find($gameId);

        if (!$game->is_end) {
            return false;
        }
        
        if ($this->minutesSinceEnd($game) < self::FETCH_DELAY_MINUTES) {
            return false;
        }

        return true;
    }
    
    private function minutesSinceEnd(Game $game): float
    {
        $startDate = Carbon::parse($game->date);

        return $startDate->diffInMinutes(now('UTC'));
    }
}