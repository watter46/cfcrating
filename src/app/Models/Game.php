<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
     * @param  int $fixtureId
     */
    public function scopeFixtureId(Builder $query, int $fixtureId): void
    {
        $query->where('fixture_id', $fixtureId);
    }
}
