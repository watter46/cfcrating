<?php declare(strict_types=1);

namespace App\Models\Util;

use Illuminate\Support\Carbon;


final readonly class Season
{
    private const SEASON_END_MONTH = 5;
    
    public static function current(): int
    {
        $now = now();

        $season = $now->year;

        if (1 <= $now->month && $now->month <= self::SEASON_END_MONTH) {
            return $season - 1;
        }

        return $season;
    }

    public static function fromDate(Carbon $date): int
    {
        $season = $date->year;
        
        if (1 <= $date->month && $date->month <= self::SEASON_END_MONTH) {
            return $season - 1;
        }

        return $season;
    }
}