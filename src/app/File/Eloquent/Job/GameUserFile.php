<?php declare(strict_types=1);

namespace App\File\Eloquent\Job;

use App\File\Data\FileHandler;
use App\File\PathInterface;


class GameUserFile extends FileHandler implements PathInterface
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
        $file = new RatingFile;
        $momIndexes = collect([2, 1, 3, 0, 4, 2, 3, 1, 2, 0]);

        $momGamePlayerIds = collect($file->get())
            ->map(function ($r, $i) use ($momIndexes) {
                $momIndex = $momIndexes[$i];

                return $r[$momIndex]['game_player_id'];
            });
        
        $data = collect($this->get())
            ->map(function ($gameUser, $i) use ($momGamePlayerIds) {
                $gameUser['mom_game_player_id'] = $momGamePlayerIds[$i];

                return $gameUser;
            });

        $this->writeFile($this, $data);
    }

    public function getDirPath(): string
    {
        return app_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return app_path(self::DIR_PATH.'/'.'gameUser'.self::EXTENSION);
    }
}