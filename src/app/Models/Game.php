<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Builder;

use App\UseCases\Util\TournamentType;
use App\UseCases\Admin\Game\AverageRatingUpdateRules;
use App\Models\Util\Season;


class Game extends Model
{
    use HasFactory;
    use HasUlids;

    public $incrementing = false;
    public $timestamps = false;

    protected $keyType = 'string';

    protected $dates = ['started_at', 'finished_at', 'updated_at'];

    const CREATED_AT = null;
    const UPDATED_AT = 'updated_at';

    protected function casts(): array
    {
        return [
            'score' => AsCollection::class,
            'teams' => AsCollection::class,
            'league' => AsCollection::class,
            'is_end' => 'boolean',
            'is_details_fetched' => 'boolean',
            'is_winner' => 'boolean'
        ];
    }

    protected $fillable = [
        'season',
        'is_end',
        'score',
        'teams',
        'league',
        'is_details_fetched',
        'started_at',
        'finished_at',
        'is_winner',
        'updated_at'
    ];

    /**
     * ツアーでソートする
     *
     * @param  Builder<Game> $query
     * @param  TournamentType $tournament
     */
    public function scopeTournament(Builder $query, TournamentType $tournament)
    {
        if ($tournament->isAll()) {
            return;
        }

        $query->where('league_id', $tournament->value);
    }

    /**
     * @param  Builder<Game> $query
     */
    public function scopeCurrentSeason(Builder $query): void
    {
        $query->where('season', Season::current());
    }

    /**
     * 今日までの試合を取得する
     *
     * @param  Builder<Game> $query
     */
    public function scopeUntilToday(Builder $query): void
    {
        $query
            ->where('started_at', '<=', now('UTC'))
            ->orderBy('started_at', 'desc');
    }

    /**
     * @param  Builder<Game> $query
     * @param  int $fixtureId
     */
    public function scopeFixtureId(Builder $query, int $fixtureId): void
    {
        $query->where('fixture_id', $fixtureId);
    }

    /**
     * 次の試合
     *
     * @param  Builder<Game> $query
     * @return void
     */
    public function scopeNext(Builder $query)
    {
        $query
            ->where('finished_at', '>', now('UTC'))
            ->orderBy('finished_at');
    }

    /**
     * 数日前から今までの試合を取得する
     *
     * @param  Builder<Game> $query
     * @param  int $days
     * @return void
     */
    public function scopeWithinDays(Builder $query, int $days = AverageRatingUpdateRules::RATING_PERIOD_DAYS)
    {
        $query->whereBetween(
            'finished_at', [
            Carbon::now('UTC')->subDays($days),
            Carbon::now('UTC')
        ]);
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)
            ->using(GamePlayer::class)
            ->as('gamePlayer')
            ->withPivot(
                'id',
                'is_starter',
                'grid',
                'assists',
                'goals',
                'rating'
            );
    }

    public function gamePlayers(): HasMany
    {
        return $this->hasMany(GamePlayer::class);
    }

    public function hasRatingGamePlayers(): HasMany
    {
        return $this->hasMany(GamePlayer::class)
            ->whereHas('myRating');
    }

    public function gameUser(): HasOne
    {
        return $this->hasOne(GameUser::class)
            ->where('user_id', Auth::id())
            ->withDefault(function (GameUser $gameUser) {
                $gameUser->user_id = Auth::id();
            });
    }

    public function gameUsers(): HasMany
    {
        return $this->hasMany(GameUser::class);
    }
}
