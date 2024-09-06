<?php declare(strict_types=1);

namespace File;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

use File\PathInterface;


class FileHandler
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
        
        $data = File::get($path->getFullPath());
                
        return collect(json_decode($data, true))->recursiveCollect();
    }

    protected function writeFile(PathInterface $path, Collection $data)
    {        
        File::ensureDirectoryExists($path->getDirPath());

        File::put($path->getFullPath(), $data->toJson());
    }
}