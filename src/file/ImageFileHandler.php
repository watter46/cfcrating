<?php declare(strict_types=1);

namespace File;

use Exception;
use Illuminate\Support\Facades\Storage;


class ImageFileHandler
{
    protected function existFile(ImagePathInterface $path)
    {
        return Storage::disk('public')->exists($path->path());
    }
    
    protected function getFile(ImagePathInterface $path)
    {
        if (!$this->existFile($path)) {
            throw new Exception($path->path().' が存在しません');
        }

        return Storage::disk('public')->get($path->path());
    }

    protected function writeFile(ImagePathInterface $path, string $image)
    {        
        Storage::disk('public')->makeDirectory($path->getDirPath());
        
        Storage::disk('public')->put($path->path(), $image);
    }
}