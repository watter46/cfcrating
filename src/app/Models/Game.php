<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

use App\UseCases\Util\TournamentType;


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
 */
class Game extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;
    
    protected $keyType = 'string';

    protected $dates = ['date'];
    
    protected $casts = [
        'is_end' => 'bool'
    ];

    protected function casts(): array
    {
        return [
            'score' => AsCollection::class,
            'teams' => AsCollection::class,
            'league' => AsCollection::class
        ];
    }

    protected $fillable = [
        'season',
        'date',
        'is_end',
        'score',
        'teams',
        'league',
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
        $query->where('season', 2023);
        // $query->where('season', Season::current());
    }

    /**
     * 今日までの試合を取得する
     *
     * @param  Builder<Game> $query
     */
    public function scopeUntilToday(Builder $query,): void
    {
        $query
            ->where('date', '<=', now('UTC'))
            ->orderBy('date', 'desc');
    }
    
    /**
     * @param  Builder<Game> $query
     * @param  int $fixtureId
     */
    public function scopeFixtureId(Builder $query, int $fixtureId): void
    {
        $query->where('fixture_id', $fixtureId);
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
