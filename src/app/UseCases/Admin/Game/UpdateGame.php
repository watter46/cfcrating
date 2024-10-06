<?php declare(strict_types=1);

namespace App\UseCases\Admin\Game;

use Exception;
use Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Game;
use App\UseCases\Admin\CheckAdminKey;


class UpdateGame extends CheckAdminKey
{
    public function execute(string $gameId, array $data)
    {
        try {
            Validator::validate($data, [
                'penalty.home' => 'nullable|integer|min:0',
                'penalty.away' => 'nullable|integer|min:0',
                'fulltime.home' => 'required|integer|min:0',
                'fulltime.away' => 'required|integer|min:0',
                'extratime.home' => 'nullable|integer|min:0',
                'extratime.away' => 'nullable|integer|min:0',
                'date' => 'required|date',
                'isWinner' => 'required|in:true,false,null'
            ]);

            $game = Game::query()
                ->select(['id'])
                ->find($gameId)
                ->fill([
                    'score' => collect($data)->only(['penalty', 'fulltime', 'extratime']),
                    'date' => $data['date'],
                    'isWinner' => $data['isWinner']
                ]);

            DB::transaction(function () use ($game) {
                $game->save();
            });

        } catch (Exception $e) {
            throw $e;
        }
    }
}