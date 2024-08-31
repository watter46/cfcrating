<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameDetail;

use Illuminate\Support\Collection;

use App\Domain\Game\LeagueId;


readonly class League
{    
    private function __construct(
        private LeagueId $leagueId,
        private string $name,
        private int $season,
        private string $round
    ) {
        
    }

    public static function create(Collection $raw_league)
    {
        return new self(
            LeagueId::create($raw_league['id']),
            $raw_league['name'],
            $raw_league['season'],
            $raw_league['round']
        );
    }

    public function leagueId()
    {
        return $this->leagueId;
    }

    public function toCollect()
    {
        return collect([
            'id' => $this->leagueId->get(),
            'name' => $this->name,
            'season' => $this->season,
            'round' => $this->round
        ]);
    }

    public function toJson()
    {
        return collect([
            'id' => $this->leagueId->get(),
            'name' => $this->name,
            'season' => $this->season,
            'round' => $this->round
        ])
        ->toJson();
    }
}