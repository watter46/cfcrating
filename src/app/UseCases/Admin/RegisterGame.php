<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use Illuminate\Support\Facades\DB;

use App\UseCases\Admin\ApiFootballRepositoryInterface;
use App\UseCases\Admin\GameDetailRepositoryInterface;
use App\UseCases\Admin\Command\GameCommand;


class RegisterGame
{
    public function __construct(
        private ApiFootballRepositoryInterface $apiFootballRepository,
        private GameDetailRepositoryInterface $gameDetailRepository
    ) {
        
    }
    
    public function execute(GameCommand $command)
    {
        $apiGameDetail = $this->apiFootballRepository->fetchFixture($command->gameId());

        $gameDetail = $this->gameDetailRepository
            ->find($command->gameId())
            ->update($apiGameDetail);

        DB::transaction(function () use ($gameDetail) {
            $this->gameDetailRepository->save($gameDetail);
        });
    }
}