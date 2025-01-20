<?php declare(strict_types=1);

namespace Tests\Unit\Admin\Schedule;

use Database\Seeders\JobGamesSeeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Tests\Unit\Admin\AdminTestCase;

use App\Jobs\UpdateGameJob;
use App\Models\Game;


class UpdateGameJobTest extends AdminTestCase
{
    protected $seeder = JobGamesSeeder::class;

    public function setUp(): void
    {
        parent::setUp();

        $this->assertDatabaseCount('games', 2);

        $this->assertDatabaseHas('games', [
            'id' => '01JD18AVTFDMJXM4DJMP4PY57M',
            'started_at' => '2024-11-11 00:00:00',
            'finished_at' => '2024-11-11 00:02:00',
        ]);

        $this->assertDatabaseHas('games', [
            'id' => '01JD18AVT9AYM6PQMVHFCM4SRA',
            'started_at' => '2024-11-12 00:00:00',
            'finished_at' => '2024-11-12 00:02:00',
        ]);
    }

    public function test_試合開始前かつキャッシュがないときfalseを返す(): void
    {
        Carbon::setTestNow('2024-11-10 23:59:59');

        $shouldJob = UpdateGameJob::shouldScheduleJob();

        $this->assertFalse($shouldJob);

        $game = Cache::get('fixture:is_end');

        $this->assertSame('01JD18AVTFDMJXM4DJMP4PY57M', $game['id']);
    }

    public function test_試合開始前のときfalseを返す(): void
    {
        Carbon::setTestNow('2024-11-10 23:59:59');

        Cache::put('fixture:is_end', [
            'id' => '01JD18AVTFDMJXM4DJMP4PY57M',
            'started_at' => '2024-11-11 00:00:00',
            'finished_at' => '2024-11-11 00:02:00',
        ]);

        $shouldJob = UpdateGameJob::shouldScheduleJob();

        $this->assertFalse($shouldJob);
    }

    public function test_試合中のときfalseを返す(): void
    {
        Carbon::setTestNow('2024-11-11 00:01:59');

        Cache::put('fixture:is_end', [
            'id' => '01JD18AVTFDMJXM4DJMP4PY57M',
            'started_at' => '2024-11-11 00:00:00',
            'finished_at' => '2024-11-11 00:02:00',
        ]);

        $shouldJob = UpdateGameJob::shouldScheduleJob();

        $this->assertFalse($shouldJob);
    }

    public function test_試合後かつまだデータを更新していないときtrueを返す(): void
    {
        Carbon::setTestNow('2024-11-11 00:02:00');

        Cache::put('fixture:is_end', [
            'id' => '01JD18AVTFDMJXM4DJMP4PY57M',
            'started_at' => '2024-11-11 00:00:00',
            'finished_at' => '2024-11-11 00:02:00',
        ]);

        $shouldJob = UpdateGameJob::shouldScheduleJob();

        $this->assertTrue($shouldJob);
    }

    public function test_試合後のときtrueを返して次の試合をキャッシュする(): void
    {
        Game::find('01JD18AVTFDMJXM4DJMP4PY57M')->update(['is_end' => true]);
        
        Carbon::setTestNow('2024-11-11 00:02:00');

        Cache::put('fixture:is_end', [
            'id' => '01JD18AVTFDMJXM4DJMP4PY57M',
            'started_at' => '2024-11-11 00:00:00',
            'finished_at' => '2024-11-11 00:02:00',
        ]);

        $shouldJob = UpdateGameJob::shouldScheduleJob();

        $this->assertFalse($shouldJob);

        $game = Cache::get('fixture:is_end');

        $this->assertSame('01JD18AVT9AYM6PQMVHFCM4SRA', $game['id']);
    }
}