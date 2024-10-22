<?php declare(strict_types=1);

namespace App\UseCases\Admin\Player;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\Player;
use App\Rules\Position;
use App\UseCases\Admin\CheckAdminKey;
use App\Models\Util\PositionType;


class UpdatePlayer extends CheckAdminKey
{
    public function execute(string $playerId, array $data)
    {
        try {
            Validator::validate($data, [
                'name'     => 'nullable|string',
                'position' => ['nullable', 'string', new Position()],
                'number'   => 'nullable|integer',
            ]);

            if (isset($data['position'])) {
                $data['position'] = PositionType::fromMix($data['position']);
            }
    
            $player = Player::query()
                ->select(['id'])
                ->find($playerId)
                ->fill($data);
                
            DB::transaction(function () use ($player) {
                $player->save();
            });

        } catch (Exception $e) {
            throw $e;
        }
    }
}