<?php declare(strict_types=1);

namespace App\File\Eloquent\Job;

use App\File\Data\FileHandler;
use App\File\PathInterface;
use App\Models\Game;
use Str;

class RatingFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/Job/Eloquent';
    private const EXTENSION = '.json';

    /**
     * 1310475 2024-10-29 Newcastle   
     * 1208117 2024-11-04 Manchester United
     */     
    
    public function get()
    {
        return $this->getFile($this)->toArray();
    }

    public function write()
    {
        $game = Game::select('id')->fixtureId(1310475)->first();
        
        $gamePlayerIds = $game->load('gamePlayers')->gamePlayers->take(5)->pluck('id');

        $ratings = collect([
            [4.5, 6.2, 7.8, 5.9, 8.3],
            [5.1, 7.3, 6.8, 9.0, 4.7],
            [8.2, 5.6, 7.4, 6.9, 9.1],
            [6.3, 8.7, 5.2, 7.1, 9.5],
            [4.8, 6.5, 8.9, 7.2, 5.7],
            [7.6, 5.3, 9.2, 6.7, 8.1],
            [5.9, 7.8, 6.1, 8.5, 4.9],
            [8.8, 6.4, 7.5, 5.0, 9.3],
            [5.4, 7.9, 6.6, 8.2, 9.7],
            [6.0, 8.6, 7.0, 5.5, 9.4] 
        ]);
        
        $gameUser = new GameUserFile;

        $data = collect($gameUser->get())
            ->pluck('user_id')
            ->map(function ($userId, $index) use ($gamePlayerIds, $ratings) {
                return $gamePlayerIds
                    ->map(function ($gamePlayerId, $ratingIndex) use ($userId, $ratings, $index) {
                        return [
                            'rating' => $ratings[$index][$ratingIndex],
                            'rate_count' => 1,
                            'game_player_id' => $gamePlayerId,
                            'user_id' => $userId
                        ];
                    });
            });

        $this->writeFile($this, $data);
    }

    public function getDirPath(): string
    {
        return app_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return app_path(self::DIR_PATH.'/'.'rating'.self::EXTENSION);
    }
}