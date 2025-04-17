<?php declare(strict_types=1);

namespace App\UseCases\Admin\Game;

use Validator;
use Illuminate\Support\Facades\DB;
use Exception;

use App\UseCases\Admin\CheckAdminKey;
use App\Models\Game;


class EditGame extends CheckAdminKey
{
    public function execute(string $gameId, array $data)
    {
        try {
            Validator::validate($data, [
                'penalty.home' => 'nullable|integer|min:0',
                'penalty.away' => 'nullable|integer|min:0',
                'fulltime.home' => 'nullable|integer|min:0',
                'fulltime.away' => 'nullable|integer|min:0',
                'extratime.home' => 'nullable|integer|min:0',
                'extratime.away' => 'nullable|integer|min:0',
                'started_at' => 'nullable|date',
                'finished_at' => 'nullable|date',
                'is_winner' => 'nullable|boolean'
            ]);

            $game = Game::query()
                ->select(['id'])
                ->find($gameId)
                ->fill($data);

            DB::transaction(function () use ($game) {
                $game->save();
            });

        } catch (Exception $e) {
            throw $e;
        }
    }
}
