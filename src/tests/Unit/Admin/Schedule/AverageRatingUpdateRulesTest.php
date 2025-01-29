<?php declare(strict_types=1);

namespace Tests\Unit\Admin\Schedule;

use App\Models\Game;
use Database\Seeders\JobGamesSeeder;
use Illuminate\Support\Carbon;
use Tests\Unit\Admin\AdminTestCase;

use App\UseCases\Admin\Game\AverageRatingUpdateRules;


class AverageRatingUpdateRulesTest extends AdminTestCase
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

    public function test_更新期間前の時falseを返す()
    {
        Carbon::setTestNow('2024-11-11 02:14:59');

        $rule = new AverageRatingUpdateRules;

        $this->assertFalse($rule->shouldUpdate());
    }

    public function test_更新期間中の時trueを返す()
    {
        Carbon::setTestNow('2024-11-11 02:15:00');

        $rule = new AverageRatingUpdateRules;

        $this->assertTrue($rule->shouldUpdate());
    }

    public function test_更新期間後の時falseを返す()
    {
        Carbon::setTestNow('2024-11-15 02:00:01');

        $rule = new AverageRatingUpdateRules;

        $this->assertFalse($rule->shouldUpdate());
    }

    public function test_1試合のみの更新期間中の時idを1つ返す()
    {
        Carbon::setTestNow('2024-11-11 02:15:00');

        $rule = new AverageRatingUpdateRules;

        $this->assertCount(1, $rule->gameIdsToUpdate());
    }

    public function test_2試合の更新期間がかぶっている時idを2つ返す()
    {
        Carbon::setTestNow('2024-11-12 02:15:00');

        $rule = new AverageRatingUpdateRules;

        $this->assertCount(2, $rule->gameIdsToUpdate());
    }

    public function test_2試合目のみの更新期間中の時idを1つ返す()
    {
        Carbon::setTestNow('2024-11-14 02:15:00');

        $rule = new AverageRatingUpdateRules;

        $this->assertCount(1, $rule->gameIdsToUpdate());
    }

    public function test_1試合目がインターバル内で更新済みの場合falseを返す()
    {
        Carbon::setTestNow('2024-11-11 02:30:01');
        
        Game::find('01JD18AVTFDMJXM4DJMP4PY57M')->update(['updated_at' => '2024-11-11 02:15:01']);

        $rule = new AverageRatingUpdateRules;

        $this->assertFalse($rule->shouldUpdate());
    }

    public function test_1試合目が更新済みかつインターバル後の場合trueを返す()
    {
        Carbon::setTestNow('2024-11-11 02:30:02');
        
        Game::find('01JD18AVTFDMJXM4DJMP4PY57M')->update(['updated_at' => '2024-11-11 02:15:01']);

        $rule = new AverageRatingUpdateRules;

        $this->assertTrue($rule->shouldUpdate());
    }

    public function test_2試合の更新期間がかぶっているかつ1試合目がインターバル外の時idを1つ返す()
    {
        Carbon::setTestNow('2024-11-12 02:30:02');
        
        Game::find('01JD18AVTFDMJXM4DJMP4PY57M')->update(['updated_at' => '2024-11-12 02:15:02']);
        Game::find('01JD18AVT9AYM6PQMVHFCM4SRA')->update(['updated_at' => '2024-11-12 02:15:01']);
        
        $rule = new AverageRatingUpdateRules;

        $this->assertCount(1, $rule->gameIdsToUpdate());
    }

    public function test_初期インターバルを超えて更新期間外の時falseを返す()
    {
        Carbon::setTestNow('2024-11-11 06:00:00');
        
        Game::find('01JD18AVTFDMJXM4DJMP4PY57M')->update(['updated_at' => '2024-11-11 05:00:00']);

        $rule = new AverageRatingUpdateRules;

        $this->assertFalse($rule->shouldUpdate());
    }

    public function test_初期インターバルを超えて更新期間外中の時trueを返す()
    {
        Carbon::setTestNow('2024-11-11 06:00:01');
        
        Game::find('01JD18AVTFDMJXM4DJMP4PY57M')->update(['updated_at' => '2024-11-11 05:00:00']);

        $rule = new AverageRatingUpdateRules;

        $this->assertTrue($rule->shouldUpdate());
    }
}