<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property int $fixture_id
 * @property int $league_id
 * @property int $season
 * @property Carbon $date
 * @property bool $is_end
 * @property AsCollection $score
 * @property AsCollection $teams
 * @property AsCollection $league
 * @property-read \App\Models\GamePlayer $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Player> $gamePlayers
 * @property-read int|null $game_players_count
 * @method static \Database\Factories\GameFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Game fixtureId(int $fixtureId)
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereFixtureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereIsEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereLeague($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereLeagueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereSeason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereTeams($value)
 */
	class Game extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|GamePlayer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GamePlayer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GamePlayer query()
 */
	class GamePlayer extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $position
 * @property int $season
 * @property int|null $number
 * @property int $api_player_id
 * @property string|null $flash_id
 * @property string|null $flash_image_id
 * @property-read \App\Models\GamePlayer $game_player
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Game> $games
 * @property-read int|null $games_count
 * @method static \Illuminate\Database\Eloquent\Builder|Player newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player query()
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereApiPlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereFlashId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereFlashImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereInApiPlayerId(\Illuminate\Support\Collection $apiPlayerIds)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereNotInApiPlayerId(\Illuminate\Support\Collection $apiPlayerIds)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereSeason($value)
 */
	class Player extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Rating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating query()
 */
	class Rating extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property int $mom_count
 * @property int $user_id
 * @property string $game_id
 * @method static \Illuminate\Database\Eloquent\Builder|UserGameStat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserGameStat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserGameStat query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserGameStat whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserGameStat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserGameStat whereMomCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserGameStat whereUserId($value)
 */
	class UserGameStat extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property float|null $rating
 * @property int $is_mom
 * @property string $game_player_id
 * @method static \Illuminate\Database\Eloquent\Builder|UsersRating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UsersRating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UsersRating query()
 * @method static \Illuminate\Database\Eloquent\Builder|UsersRating whereGamePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersRating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersRating whereIsMom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersRating whereRating($value)
 */
	class UsersRating extends \Eloquent {}
}

