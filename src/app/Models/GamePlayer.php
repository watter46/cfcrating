<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;


class GamePlayer extends Pivot
{
    use HasFactory;
    use HasUlids;

    public $incrementing = false;
    public $timestamps = false;
    
    protected $keyType = 'string';

    protected $table = 'game_player';

    /**
     * @param  Builder<GamePlayer> $query
     * @param  string $gameId
     */
    public function scopeGameId(Builder $query, $gameId): void
    {
        $query->where('game_id', $gameId);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'game_player_id');
    }

    public function usersRating(): HasOne
    {
        return $this->hasOne(UsersRating::class, 'game_player_id');
    }
}
