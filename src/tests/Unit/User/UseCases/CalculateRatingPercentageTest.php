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
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnks'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnkt'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnkv'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnkw'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnkx'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnky'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnkz'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnm0'],
        ]);
        
        $calculateRatingPercentage = app(CalculateRatingPercentage::class);

        $percentage = $calculateRatingPercentage->execute('01JD18AVT8PHWC5YRH6EERNW2N');

        $this->assertSame(50, $percentage);
    }

    public function test_評価されていないとき100％になる(): void
    {
        Rating::insert([
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnks'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnkt'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnkv'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnkw'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnkx'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnky'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnkz'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnm0'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnm1'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnm2'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnm3'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnm4'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnm5'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnm6'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnm7'],
            ['id' => (string) Str::ulid(), 'rating' => 6.0, 'rate_count' => 1, 'user_id' => 1 , 'game_player_id' => '01jd18avzkyr2bj21ardp1hnm8']
        ]);

        $calculateRatingPercentage = app(CalculateRatingPercentage::class);

        $percentage = $calculateRatingPercentage->execute('01JD18AVT8PHWC5YRH6EERNW2N');

        $this->assertSame(100, $percentage);
    }
}