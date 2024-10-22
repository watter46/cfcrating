<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use Exception;
use Illuminate\Support\Facades\DB;

use App\Models\UsersRating as UsersRatingModel;


class UpdateUsersRating
{
    public function __construct(private UsersRating $usersRating)
    {
        //
    }

    /**
     * 指定の試合のユーザー全体の平均評価点を保存する
     *
     * @return void
     */
    public function execute(string $gameId)
    {
        try {            
            $data = $this->usersRating->upsert($gameId);
            
            DB::transaction(function () use ($data) {                
                UsersRatingModel::upsert(
                    $data->toArray(),
                    'id'
                );
            });

        } catch (Exception $e) {
            throw $e;
        }
    }
}