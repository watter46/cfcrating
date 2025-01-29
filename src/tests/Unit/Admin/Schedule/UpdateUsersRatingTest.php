<?php declare(strict_types=1);

namespace Tests\Unit\Admin\Schedule;

use Database\Seeders\Test\AverageRatingsSeeder;
use Tests\Unit\Admin\AdminTestCase;
use Illuminate\Support\Str;

use App\Models\UsersRating;
use App\UseCases\Admin\UpdateUsersRating;


class UpdateUsersRatingTest extends AdminTestCase
{
    protected $seeder = AverageRatingsSeeder::class;
    
    public function setUp(): void
    {
        parent::setUp();
        
        $this->assertDatabaseHas('ratings', ['game_player_id' => '01jd18axeyvnnbj8hm3kyq2e38']);
        $this->assertDatabaseHas('ratings', ['game_player_id' => '01jd18axeyvnnbj8hm3kyq2e39']);
        $this->assertDatabaseHas('ratings', ['game_player_id' => '01jd18axeyvnnbj8hm3kyq2e3a']);
        $this->assertDatabaseHas('ratings', ['game_player_id' => '01jd18axeyvnnbj8hm3kyq2e3b']);
        $this->assertDatabaseHas('ratings', ['game_player_id' => '01jd18axeyvnnbj8hm3kyq2e3c']);

        $this->assertDatabaseEmpty('users_ratings');
    }

    public function test_ユーザー全てのレーティングとMOMの平均を求められる(): void
    {
        /** @var UpdateUsersRating $updateUsersRating */
        $updateUsersRating = app(UpdateUsersRating::class);

        $updateUsersRating->execute('01JD18AVTFDMJXM4DJMP4PY57M');

        $usersRatings = UsersRating::whereIn('game_player_id', [
            '01jd18axeyvnnbj8hm3kyq2e38',
            '01jd18axeyvnnbj8hm3kyq2e39',
            '01jd18axeyvnnbj8hm3kyq2e3a',
            '01jd18axeyvnnbj8hm3kyq2e3b',
            '01jd18axeyvnnbj8hm3kyq2e3c'
        ])
        ->pluck('rating');
        
        $this->assertDatabaseHas('users_ratings', ['game_player_id' => '01jd18axeyvnnbj8hm3kyq2e38', 'is_mom' => 0]);
        $this->assertDatabaseHas('users_ratings', ['game_player_id' => '01jd18axeyvnnbj8hm3kyq2e39', 'is_mom' => 0]);
        $this->assertDatabaseHas('users_ratings', ['game_player_id' => '01jd18axeyvnnbj8hm3kyq2e3a', 'is_mom' => 1]);
        $this->assertDatabaseHas('users_ratings', ['game_player_id' => '01jd18axeyvnnbj8hm3kyq2e3b', 'is_mom' => 0]);
        $this->assertDatabaseHas('users_ratings', ['game_player_id' => '01jd18axeyvnnbj8hm3kyq2e3c', 'is_mom' => 0]);

        $this->assertSame($usersRatings->toArray(), [6.3, 7.0, 7.3, 7.0, 7.9]);
    }

    public function test_すでにUsersRatingレコードが保存されている時更新できる(): void
    {
        $id = (string) Str::ulid();
        
        $usersRating = new UsersRating;
        $usersRating->id = $id;
        $usersRating->game_player_id = '01jd18axeyvnnbj8hm3kyq2e38';
        $usersRating->rating = 5.0;
        $usersRating->is_mom = 0;

        $usersRating->save();
        
        $this->assertDatabaseHas('users_ratings', [
            'id' => $id,
            'game_player_id' => $usersRating->game_player_id,
            'is_mom' => $usersRating->is_mom
        ]);
        
        $this->assertSame(UsersRating::find($id)->rating, 5.0);
        
        /** @var UpdateUsersRating $updateUsersRating */
        $updateUsersRating = app(UpdateUsersRating::class);

        $updateUsersRating->execute('01JD18AVTFDMJXM4DJMP4PY57M');

        $this->assertDatabaseHas('users_ratings', [
            'id' => $id,
            'game_player_id' => $usersRating->game_player_id,
            'is_mom' => $usersRating->is_mom
        ]);
        
        $this->assertSame(UsersRating::find($id)->rating, 6.3);
    }
}