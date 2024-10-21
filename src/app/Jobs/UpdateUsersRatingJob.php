<?php declare(strict_types=1);

namespace App\Jobs;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

use App\Models\Game;
use App\UseCases\Admin\Game\GameRule;
use App\UseCases\Admin\UpdateUsersRating;


class UpdateUsersRatingJob implements ShouldQueue
{
    use Queueable;

    private UpdateUsersRating $updateUsersRating;

    public $tries = 1;

    public $maxExceptions = 1;
    
    /**
     * Create a new job instance.
     */
    public function __construct(private int $retryCount = 0)
    {
        $this->updateUsersRating = app(UpdateUsersRating::class);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $gameIds = Game::query()
            ->currentSeason()
            ->WithinRatingPeriod()
            ->pluck('id');
        
        try {
            $gameIds
                ->each(function (string $gameId) {
                    $this->updateUsersRating->execute($gameId);
                });

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function failed(?Throwable $exception): void
    {
        if ($this->retryCount >= GameRule::MAX_RETRY_COUNT) {
            return; 
        }
        
        self::dispatch($this->retryCount + 1)
            ->delay(now('UTC')->addMinutes(GameRule::RETRY_DELAY_MINUTES));
    }

    public static function shouldScheduleJob()
    {
        return Game::query()
            ->currentSeason()
            ->WithinRatingPeriod()
            ->exists();
    }

    public function uniqueId(): string
    {
        return 'update-users-rating';
    }
}