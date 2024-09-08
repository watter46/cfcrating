<?php declare(strict_types=1);

namespace App\Models;

use App\Domain\Game\Season;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
     * @param  Builder<Game> $query
     */
    public function scopeCurrentSeason(Builder $query): void
    {
        $query->where('season', 2023);
        // $query->where('season', Season::current());
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

    public function gameUser(): HasMany
    {
        return $this->hasMany(GameUser::class)
            // ->where('user_id', Auth::user()->id)
            ;
    }
}
