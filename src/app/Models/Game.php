<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\Util\Season;
use App\UseCases\Util\TournamentType;

class Game extends Model
{
    use HasFactory;
    use HasUlids;

    public $incrementing = false;
    public $timestamps = false;
    
    protected $keyType = 'string';

    protected $dates = ['started_at', 'finished_at'];

    protected function casts(): array
    {
        return [
            'score' => AsCollection::class,
            'teams' => AsCollection::class,
            'league' => AsCollection::class,
            'is_end' => 'boolean',
            'is_details_fetched' => 'boolean'
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
    public function scopeUntilToday(Builder $query,): void
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
            ->where('started_at', '>', now('UTC'))
            ->orderBy('started_at');
    }

    /**
     * 次の試合
     *
     * @param  Builder<Game> $query
     * @return void
     */
    public function scopeWithinThreeDays(Builder $query)
    {
        $query->whereBetween('finished_at', Carbon::now()->subDays(3));
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
}
