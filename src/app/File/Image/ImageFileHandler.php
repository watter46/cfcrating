<?php declare(strict_types=1);

namespace App\File\Image;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class ImageFileHandler
{
    protected function files(ImagePathInterface $path)
    {
        return Storage::disk('public')->files($path->getDirPath());
    }

    protected function ensureDirectoryExists(ImagePathInterface $path)
    {
        if (Storage::disk('public')->exists($path->getDirPath())) {
            return;
        }

        Storage::disk('public')->makeDirectory($path->getDirPath());
    }

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

        $success = Storage::disk('public')->put($path->path(), $image);

        if (!$success) {
            Log::error("Failed to write file to storage: " . $path->path());
        }
    }
}
