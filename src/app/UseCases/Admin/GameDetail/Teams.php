<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameDetail;

use App\Domain\Game\TeamId;
use Illuminate\Support\Collection;


readonly class Teams
{
    private function __construct(private Collection $teams)
    {
        
    }
    
    public static function create(Collection $raw_teams): self
    {
        return new self(
            $raw_teams
                ->map(function (Collection $team) {
                    return [
                        'id'     => $team['id'],
                        'name'   => $team['name'],
                        'winner' => $team['winner']
                    ];
                })
        );
    }

    public function teamIds()
    {
        return $this->teams
            ->pluck('id')
            ->map(fn(int $id) => TeamId::create($id));
    }

    public function toCollect()
    {
        return $this->teams;
    }

    public function toJson()
    {
        return $this->teams->toJson();
    }
}