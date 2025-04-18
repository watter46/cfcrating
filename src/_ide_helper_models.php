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
 * @property mixed $password
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
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
 * @property bool $is_end
 * @property \Illuminate\Support\Collection $score
 * @property \Illuminate\Support\Collection $teams
 * @property \Illuminate\Support\Collection $league
 * @property bool $is_details_fetched
 * @property string $started_at
 * @property string|null $finished_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GamePlayer> $gamePlayers
 * @property-read int|null $game_players_count
 * @property-read \App\Models\GameUser $gameUser
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GamePlayer> $hasRatingGamePlayers
 * @property-read int|null $has_rating_game_players_count
 * @property-read \App\Models\GamePlayer $gamePlayer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Player> $players
 * @property-read int|null $players_count
 * @method static \Illuminate\Database\Eloquent\Builder|Game currentSeason()
 * @method static \Database\Factories\GameFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Game fixtureId(int $fixtureId)
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game next()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder|Game tournament(\App\UseCases\Util\TournamentType $tournament)
 * @method static \Illuminate\Database\Eloquent\Builder|Game untilToday()
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereFixtureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereIsDetailsFetched($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereIsEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereLeague($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereLeagueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereSeason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereTeams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game withInThreeDays()
 */
	class Game extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property bool $is_starter
 * @property string|null $grid
 * @property int $assists
 * @property int $goals
 * @property float|null $rating
 * @property string $game_id
 * @property string $player_id
 * @property-read \App\Models\Rating $myRating
 * @property-read \App\Models\Player $player
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rating> $ratings
 * @property-read int|null $ratings_count
 * @property-read \App\Models\UsersRating|null $usersRating
 * @method static \Database\Factories\GamePlayerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|GamePlayer gameId($gameId)
 * @method static \Illuminate\Database\Eloquent\Builder|GamePlayer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GamePlayer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GamePlayer query()
 * @method static \Illuminate\Database\Eloquent\Builder|GamePlayer whereAssists($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GamePlayer whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GamePlayer whereGoals($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GamePlayer whereGrid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GamePlayer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GamePlayer whereIsStarter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GamePlayer wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GamePlayer whereRating($value)
 */
	class GamePlayer extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property int $is_rated
 * @property int $mom_count
 * @property string|null $mom_game_player_id
 * @property int $user_id
 * @property string $game_id
 * @method static \Illuminate\Database\Eloquent\Builder|GameUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|GameUser whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameUser whereIsRated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameUser whereMomCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameUser whereMomGamePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameUser whereUserId($value)
 */
	class GameUser extends \Eloquent {}
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
 * @property int $is_fetched
 * @property string|null $flash_id
 * @property string|null $flash_image_id
 * @property-read \App\Models\GamePlayer|null $gamePlayer
 * @method static \Illuminate\Database\Eloquent\Builder|Player currentSeason()
 * @method static \Database\Factories\PlayerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Player newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player query()
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereApiPlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereFlashId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereFlashImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereInApiPlayerId(\Illuminate\Support\Collection $apiPlayerIds)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereIsFetched($value)
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
 * @property string $id
 * @property float|null $rating
 * @property int $rate_count
 * @property int $user_id
 * @property string $game_player_id
 * @method static \Illuminate\Database\Eloquent\Builder|Rating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereGamePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereRateCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereUserId($value)
 */
	class Rating extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $role
 * @property mixed|null $password
 * @property string|null $remember_token
 * @property string|null $provider
 * @property string|null $provider_id
 * @property string|null $two_factor_secret
 * @property int $two_factor_enabled
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
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $game_player_id
 * @property float|null $rating
 * @property bool $is_mom
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

