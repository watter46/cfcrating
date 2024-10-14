<?php declare(strict_types=1);

namespace App\UseCases\Admin\Game;

use App\UseCases\Admin\Api\ApiFootball\Fixture;
use App\UseCases\Admin\Api\ApiFootball\Fixtures;


interface GameRepositoryInterface
{
    public function bulkSave(Fixtures $fixtures): void;
    public function save(Fixture $fixture): void;
}