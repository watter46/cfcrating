<?php declare(strict_types=1);

namespace App\UseCases\Admin\Game;

class GameRule
{
    public const DURATION_MINUTES = 120;
    public const RATING_PERIOD_DAYS = 3;

    public const RETRY_DELAY_MINUTES = 5;
    public const MAX_RETRY_COUNT = 3;
    
    public function __construct()
    {
        
    }
}