<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball;

use Illuminate\Support\Collection;


readonly class Teams
{    
    /**
     * __construct
     *
     * @param  Collection<array{id:int,name:string,isWinner:?bool}> $teams
     * @return void
     */
    private function __construct(private Collection $teams)
    {
        
    }
    
    public static function create(Collection $rawTeams): self
    {
        return new self(
            $rawTeams
                ->map(function (Collection $rawTeam) {
                    return [
                        'id'       => $rawTeam['id'],
                        'name'     => $rawTeam['name'],
                        'isWinner' => $rawTeam['winner']
                    ];
                })
        );
    }

    public function teamIds()
    {
        return $this->teams->pluck('id');
    }

    public function get()
    {
        return $this->teams;
    }
}