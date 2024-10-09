<?php declare(strict_types=1);

namespace File;

use Exception;
use File\PathInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageFileHandler
{
    protected function existFile(PathInterface $path)
    {
        return File::exists($path->getFullPath());
    }
    
    protected function getFile(PathInterface $path)
    {
        if (!$this->existFile($path)) {
            throw new Exception($path->getFullPath().' が存在しません');
        }
        
        return File::get($path->getFullPath());
    }

    protected function writeFile(PathInterface $path, string $image)
    {        
        File::ensureDirectoryExists($path->getDirPath());

        // Storage::disk('public')->put($path->getFullPath(), $image);
        
        // $url = Storage::url($path->getFullPath());

        // dd($url);
        
        file_put_contents($path->getFullPath(), $image);
        // File::put($path->getFullPath(), $image);
    }
}