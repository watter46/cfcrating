<?php declare(strict_types=1);

namespace App\File\Image;


interface ImagePathInterface
{
    public const STORAGE_PATH = 'storage';

    public function path(): string;
    public function getDirPath(): string;
}