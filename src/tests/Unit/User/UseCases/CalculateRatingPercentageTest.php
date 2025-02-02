<?php

namespace Tests\Unit\User\UseCases;

use App\Models\Rating;
use App\UseCases\User\CalculateRatingPercentage;
use Database\Seeders\Test\UserOneGameSeeder;
use Illuminate\Support\Str;
use Tests\Unit\User\UserTestCase;


class CalculateRatingPercentageTest extends UserTestCase
{
    protected $seeder = UserOneGameSeeder::class;

    public function test_評価されていないとき0％になる(): void
    {
        $calculateRatingPercentage = app(CalculateRatingPercentage::class);

        $percentage = $calculateRatingPercentage->execute('01JD18AVT8PHWC5YRH6EERNW2N');

        $this->assertSame(0, $percentage);
    }

    public function test_評価されていないとき50％になる(): void
    {
        Rating::insert([
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j3sf17rsh4k2cweatz'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49m'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49n'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49p'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49q'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49r'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49s'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49t'],
        ]);

        $calculateRatingPercentage = app(CalculateRatingPercentage::class);

        $percentage = $calculateRatingPercentage->execute('01JD18AVT8PHWC5YRH6EERNW2N');

        $this->assertSame(50, $percentage);
    }

    public function test_評価されていないとき100％になる(): void
    {
        Rating::insert([
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j3sf17rsh4k2cweatz'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49m'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49n'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49p'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49q'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49r'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49s'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49t'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49v'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49w'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49x'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49y'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh49z'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh4a0'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh4a1'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jjyq12j4391yv97qvt0sh4a2']
        ]);

        $calculateRatingPercentage = app(CalculateRatingPercentage::class);

        $percentage = $calculateRatingPercentage->execute('01JD18AVT8PHWC5YRH6EERNW2N');

        $this->assertSame(100, $percentage);
    }
}
