<?php declare(strict_types=1);

use Illuminate\Support\Facades\Schedule;

use App\Jobs\UpdateGameJob;
use App\Jobs\UpdateGamesJob;
use App\Jobs\UpdateUsersRatingJob;

/** 試合後にFixtureデータをAPIから取得してDBを更新 */
Schedule::job(new UpdateGameJob)
    ->when(fn() => UpdateGameJob::shouldScheduleJob())
    ->everyThirtySeconds();
    
/** FixturesデータをAPIから取得してDBを更新する */
Schedule::job(new UpdateGamesJob)
    ->days([1, 4]) // 月曜日と木曜日
    ->at('23:00')
    ->timezone('UTC');

/** ユーザーの平均レーティングを更新する */
Schedule::job(new UpdateUsersRatingJob)
    ->when(fn() => UpdateUsersRatingJob::shouldScheduleJob())
    ->dailyAt('04:00')
    ->timezone('UTC');