<?php declare(strict_types=1);

namespace Tests\Unit\Model;

use App\Models\Game;
use Database\Seeders\JobGamesSeeder;
use Illuminate\Support\Carbon;
use Tests\Unit\Admin\AdminTestCase;

class GameTest extends AdminTestCase
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

    public function test_次の試合を取得できるか(): void
    {
        Carbon::setTestNow('2024-11-10 23:59:59');

        $game = Game::next()->first();

        $this->assertSame('01JD18AVTFDMJXM4DJMP4PY57M', $game->id);
    }

    public function test_試合中の時の次の試合を取得できるか(): void
    {
        Carbon::setTestNow('2024-11-11 01:59:59');

        $game = Game::next()->first();

        $this->assertSame('01JD18AVTFDMJXM4DJMP4PY57M', $game->id);
    }

    public function test_試合後に次の試合を取得できるか(): void
    {
        Carbon::setTestNow('2024-11-11 02:00:00');

        $game = Game::next()->first();

        $this->assertSame('01JD18AVT9AYM6PQMVHFCM4SRA', $game->id);
    }
}
