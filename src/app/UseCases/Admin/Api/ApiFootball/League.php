<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball;

use Illuminate\Support\Collection;


readonly class League
{
    private function __construct(
        private int $leagueId,
        private string $name,
        private int $season,
        private string $round
    ) {
        
    }

    public static function create(Collection $rawLeague)
    {
        return new self(
            $rawLeague['id'],
            $rawLeague['name'],
            $rawLeague['season'],
            $rawLeague['round']
        );
    }

    public function leagueId()
    {
        return $this->leagueId;
    }

    public function get()
    {
        return collect([
            'id' => $this->leagueId,
            'name' => $this->name,
            'season' => $this->season,
            'round' => $this->round
        ]);
    }
}