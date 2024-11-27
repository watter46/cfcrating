<?php declare(strict_types=1);

namespace App\UseCases\Admin\Game;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\GamePlayer;
use App\UseCases\Admin\CheckAdminKey;


class UpdateGamePlayer extends CheckAdminKey
{
    public function execute(string $gamePlayerId, array $data)
    {
        try {
            Validator::validate($data, [
                'goals' => 'required|integer|min:0|max:10',
                'assists' => 'required|integer|min:0|max:10',
            ]);

            $gamePlayer = GamePlayer::query()
                ->select(['id', 'goals', 'assists'])
                ->find($gamePlayerId)
                ->fill($data);

            DB::transaction(function () use ($gamePlayer) {
                $gamePlayer->save();
            });

        } catch (Exception $e) {
            throw $e;
        }
    }
}