<?php declare(strict_types=1);

namespace Tests\Unit\Admin\Schedule;

use Database\Seeders\JobGamesSeeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Tests\Unit\Admin\AdminTestCase;

use App\Jobs\UpdateUsersRatingJob;


class UpdateUsersRatingJobTest extends AdminTestCase
{
    protected $seeder = JobGamesSeeder::class;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->assertDatabaseCount('games', 2);

        $this->assertDatabaseHas('games', [
            'id' => '01JD18AVTFDMJXM4DJMP4PY57M',
            'started_at' => '2024-11-11 00:00:00',
            'finished_at' => '2024-11-11 02:00:00',
        ]);

        $this->assertDatabaseHas('games', [
            'id' => '01JD18AVT9AYM6PQMVHFCM4SRA',
            'started_at' => '2024-11-12 00:00:00',
            'finished_at' => '2024-11-12 02:00:00',
        ]);
    }
    
    public function test_更新期間前の時Jobが投入されない()
    {
        Carbon::setTestNow('2024-11-11 02:14:59');

        Queue::fake();

        $this->artisan('schedule:run')
             ->assertExitCode(0);

        Queue::assertNothingPushed();
    }

    public function test_更新期間中の時1回ジョブを投入される()
    {
        Carbon::setTestNow('2024-11-11 02:15:00');

        Queue::fake();

        $this->artisan('schedule:run')
            ->assertExitCode(0);

        Queue::assertPushed(UpdateUsersRatingJob::class, 1);
    }

    public function test_更新期間後の時falseを返す()
    {
        Carbon::setTestNow('2024-11-15 02:00:01');

        Queue::fake();

        $this->artisan('schedule:run')
             ->assertExitCode(0);

        Queue::assertNothingPushed();
    }
}