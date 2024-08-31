<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameDetail;

use App\Domain\Game\FixtureId;
use Illuminate\Support\Collection;

use App\UseCases\Admin\GameDetail\GameDetail;


class GameDetailList
{    
    /**
     * __construct
     *
     * @param  Collection<GameDetail> $gameDetailList
     * @return void
     */
    private function __construct(private Collection $gameDetailList)
    {
        
    }
    
    /**
     * create
     *
     * @param  Collection<GameDetail> $gameDetailList
     * @return self
     */
    public static function create(Collection $gameDetailList): self
    {
        return new self($gameDetailList);
    }

    public function bulkUpdate(GameDetailList $newGameDetailList): self
    {
        if ($this->gameDetailList->isEmpty()) {
            return $newGameDetailList;
        }
        
        return new self(
            $this->gameDetailList
                ->map(function (GameDetail $gameDetail) use ($newGameDetailList) {
                    $newGameDetail = $newGameDetailList->findByFixtureId($gameDetail->fixtureId());
                    
                    return $gameDetail->update($newGameDetail);
                })
        );
    }

    public function toUpsert()
    {
        return $this->gameDetailList
            ->map(fn(GameDetail $gameDetail) => $gameDetail->toUpsert())
            ->toArray();
    }

    public function findByFixtureId(FixtureId $fixtureId): GameDetail
    {
        return $this->gameDetailList
            ->first(function (GameDetail $gameDetail) use ($fixtureId) {
                return $gameDetail->equalByFixtureId($fixtureId);
            });
    }

    public function invalidImages()
    {

    }
}