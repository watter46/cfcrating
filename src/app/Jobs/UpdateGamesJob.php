<?php declare(strict_types=1);

namespace App\Jobs;

use App\UseCases\Admin\Game\GameRule;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

use App\UseCases\Admin\Game\UpdateGames;


class UpdateGamesJob implements ShouldQueue
{
    use Queueable;

    public $tries = 1;

    public $maxExceptions = 1;

    private UpdateGames $updateGames;

    public function __construct(private int $retryCount = 0)
    {
        $this->updateGames = app(UpdateGames::class);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->updateGames->execute();

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
}