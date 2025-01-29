<?php declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Throwable;

use App\Models\Game;
use App\UseCases\Admin\Exception\FixtureNotEndedException;
use App\UseCases\Admin\Game\GameRule;
use App\UseCases\Admin\Game\UpdateGame;


class UpdateGameJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    public $tries = 1;

    public $maxExceptions = 1;

    private UpdateGame $updateGame;

    public function __construct()
    {
        $this->updateGame = app(UpdateGame::class);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->updateGame->execute($this->uniqueId());

        } catch (FixtureNotEndedException $e) {
            throw $e;
        }
    }

    public function failed(?Throwable $exception): void
    {
        
    }

    /**
     * キューにスタックするか判定する
     *
     * @return bool
     */
    public static function shouldScheduleJob()
    {
        if (Cache::has('fixture:is_end')) {
            $game = Cache::get('fixture:is_end');
            
            if (Carbon::parse($game['finished_at'])->isFuture()) {
                return false;
            }

            $isEnd = Game::query()
                ->select(['id', 'is_end'])
                ->find($game['id'])
                ->is_end;

            if (!$isEnd) {
                return true;
            }

            $nextGame = Game::query()
                ->select(['id', 'finished_at'])
                ->currentSeason()
                ->next()
                ->first()
                ?->toArray();

            if (is_null($nextGame)) return false;

            Cache::put('fixture:is_end', $nextGame);

            return false;
        }
        
        $nextGame = Game::query()
            ->select(['id', 'finished_at'])
            ->currentSeason()
            ->next()
            ->first()
            ?->toArray();

        if (is_null($nextGame)) return false;
        
        Cache::put('fixture:is_end', $nextGame);

        return false;
    }

    /**
     * ジョブの一意IDの取得
     */
    public function uniqueId(): string
    {
        $game = Cache::get("fixture:is_end");

        return $game['id'];
    }
}