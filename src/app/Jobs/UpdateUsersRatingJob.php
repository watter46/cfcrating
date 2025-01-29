<?php declare(strict_types=1);

namespace App\Jobs;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\UseCases\Admin\Game\AverageRatingUpdateRules;
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
        try {
            $rule = new AverageRatingUpdateRules;
            
            $rule->gameIdsToUpdate()
                ->each(function (string $gameId) {
                    $this->updateUsersRating->execute($gameId);
                });

        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function shouldScheduleJob()
    {
        $rule = new AverageRatingUpdateRules;
        
        return $rule->shouldUpdate();
    }

    public function uniqueId(): string
    {
        return 'update-users-rating';
    }
}