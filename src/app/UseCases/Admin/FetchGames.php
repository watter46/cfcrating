<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use App\Domain\Admin\GameQueryServiceInterface;


class FetchGames
{
    public function __construct(private GameQueryServiceInterface $query)
    {
        
    }

    public function execute()
    {
        return $this->query->fetchGames();
    }
}