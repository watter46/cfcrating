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
        $game = Cache::rememberForever("fixture:is_end", function () {
            return Game::query()
                ->select(['id', 'started_at'])
                ->currentSeason()
                ->next()
                ->first()
                ->toArray();
        });

        return Carbon::parse($game['started_at'])
            ->addMinutes(GameRule::DURATION_MINUTES)
            ->isPast();
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