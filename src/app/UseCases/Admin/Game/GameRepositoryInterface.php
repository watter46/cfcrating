<?php declare(strict_types=1);

namespace App\UseCases\Admin\Game;

use App\UseCases\Admin\Api\ApiFootball\Fixture;

interface GameRepositoryInterface
{
    public function save(Fixture $fixture): void;
}