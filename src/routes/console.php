<?php declare(strict_types=1);

use Illuminate\Support\Facades\Schedule;

use Illuminate\Support\Facades\Log;
use App\Jobs\UpdateUsersRatingJob;
use App\Jobs\UpdateGamesJob;

use App\Jobs\UpdateGameJob;

Log::info("Scheduled command started at " . now());

// /** 試合後にFixtureデータをAPIから取得してDBを更新 */
// Schedule::job(new UpdateGameJob)
//     ->when(fn() => UpdateGameJob::shouldScheduleJob())
//     ->everyTenMinutes();

// /** FixturesデータをAPIから取得してDBを更新する */
// Schedule::job(new UpdateGamesJob)
//     ->days([1, 4]) // 月曜日と木曜日
//     ->at('23:00')
//     ->timezone('UTC');

// /** ユーザーの平均レーティングを更新する */
// Schedule::job(new UpdateUsersRatingJob)
//     ->when(fn() => UpdateUsersRatingJob::shouldScheduleJob())
//     ->everyFifteenMinutes();
