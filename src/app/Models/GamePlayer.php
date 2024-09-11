<?php declare(strict_types=1);

namespace App\Models;

use App\Domain\Game\TournamentType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Auth;

class GamePlayer extends Pivot
{
    use HasFactory;
    use HasUlids;

    public $incrementing = false;
    public $timestamps = false;
    
    protected $keyType = 'string';

    protected $table = 'game_player';

    protected $casts = [
        'is_starter' => 'boolean'
    ];

    /**
     * ツアーでソートする
     *
     * @param  TournamentType $tournament
     * @return Builder
     */
    public function tournament(TournamentType $tournament): Builder
    {        
        return $this->whereIn('league_id', $tournament->toIds());
    }

    /**
     * シーズン中の試合のみ取得する
     *
     * @return Builder
     */
    public function inSeasonTournament(): Builder
    {
        return $this
            ->whereIn('league_id', [
                TournamentType::PREMIER_LEAGUE->toIds(),
                TournamentType::FA_CUP->toIds(),
                TournamentType::LEAGUE_CUP->toIds()
            ]);
    }

    /**
     * まだ始まっていない試合のみ取得する
     *
     * @return Builder
     */
    public function notStarted(): Builder
    {
        return $this->where('status', FixtureStatusType::NotStarted->value);
    }
    
    /**
     * 終了している試合のみ取得する
     *
     * @return Builder
     */
    public function finished(): Builder
    {
        return $this->where('is_end', true);
    }
    
    /**
     * 次の試合を取得する
     *
     * @return Builder
     */
    public function next(): Builder
    {
        return $this
            ->whereDate('date', '>=', now('UTC'))
            ->orderBy('date')
            ->whereNull('lineups');
    }

    /**
     * 指定の期間内の試合を取得する
     *
     * @return Builder
     */
    public function last(): Builder
    {
        return $this
            ->whereDate('date', '<=', now('UTC'))
            ->where('is_end', true)
            ->orderBy('date', 'desc');
    }

    /**
     * 1か月以内の試合から取得する
     *
     * @return Builder
     */
    public function withinOneMonth(): Builder
    {
        return $this->where('date', '>=', now('UTC')->subMonth());
    }

    /**
     * 今日までの試合を取得する
     *
     * @return Builder
     */
    public function untilToday(): Builder
    {
        return $this
            ->where('date', '<=', now('UTC'))
            ->orderBy('date', 'desc');
    }

    /**
     * 今シーズンのみ取得する
     *
     * @return Builder
     */
    public function currentSeason(): Builder
    {
        return $this->where('season', Season::current());
    }
    
    /**
     * 指定したカラム名以外を取得する
     *
     * @param  array $except
     * @return Builder
     */
    public function selectWithout(array $except = []): Builder
    {
        return $this->select(
                $this->withOutTimeStamp()
                    ->flip()
                    ->except($except)
                    ->flip()
                    ->toArray()
            );
    }

    private function withOutTimeStamp(): Collection
    {
        return collect(Schema::getColumnListing('fixture_infos'))
            ->flip()
            ->except(['created_at', 'updated_at'])
            ->flip();
    }
    
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

    public function myRating(): HasOne
    {
        return $this->hasOne(Rating::class, 'game_player_id')
            ->where('user_id', Auth::user()->id);
    }

    public function usersRating(): HasOne
    {
        return $this->hasOne(UsersRating::class, 'game_player_id');
    }
}
