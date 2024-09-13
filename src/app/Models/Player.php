<?php declare(strict_types=1);

namespace App\Models;

use App\Domain\Game\Season;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class Player extends Model
{
    use HasFactory;
    use HasUlids;

    public $incrementing = false;
    public $timestamps = false;
    
    protected $keyType = 'string';

    /**
     * @param  Builder<Player> $query
     * @param  Collection $apiPlayerIds
     */
    public function scopeWhereInApiPlayerId(Builder $query, Collection $apiPlayerIds): void
    {
        $query->whereIn('api_player_id', $apiPlayerIds->toArray());
    }

    /**
     * @param  Builder<Player> $query
     * @param  Collection $apiPlayerIds
     */
    public function scopeWhereNotInApiPlayerId(Builder $query, Collection $apiPlayerIds): void
    {
        $query->whereNotIn('api_player_id', $apiPlayerIds->toArray());
    }

    /**
     * @param  Builder<Player> $query
     */
    public function scopeCurrentSeason(Builder $query): void
    {
        $query->where('season', Season::current());
    }

    public function gamePlayer(): HasOne
    {
        return $this->hasOne(GamePlayer::class);
    }
}
