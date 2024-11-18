<?php declare(strict_types=1);

namespace App\File\Image;

use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;


class PlayerImageFile extends ImageFileHandler implements ImagePathInterface
{
    private const DIR_PATH = 'image/player';
    private const DEFAULT_PATH = 'default_player.png';
    private const EXTENSION = '.png';

    private int $playerId;

    private ImageManager $manager;
    
    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function playerImageIds()
    {
        return collect($this->files($this))
            ->map(fn (string $path) => Str::of($path)->afterLast('/')->value())
            ->filter(fn(string $file) => is_numeric($file));
    }

    public function exist(int $playerId)
    {
        $this->playerId = $playerId;

        return $this->existFile($this);
    }

    public function get(int $playerId)
    {
        $this->playerId = $playerId;

        return $this->getFile($this); 
    }

    public function write(int $playerId, string $image)
    {
        $image = $this->manager->read($image);
        
        $image
            ->toPng()
            ->save($this->storagePath($playerId));
    }

    public function storagePath(int $playerId): string
    {
        $this->playerId = $playerId;
        
        return self::STORAGE_PATH.'/'.$this->path();
    }

    public function path(): string
    {
        return self::DIR_PATH.'/'.$this->playerId.self::EXTENSION;
    }

    public function defaultPath()
    {
        return self::STORAGE_PATH.'/'.self::DIR_PATH.'/'.self::DEFAULT_PATH;
    }

    public function getDirPath(): string
    {
        return self::DIR_PATH;
    }
}