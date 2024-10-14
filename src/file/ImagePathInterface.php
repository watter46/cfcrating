<?php declare(strict_types=1);

namespace File;


interface ImagePathInterface
{
    public const STORAGE_PATH = 'storage';

    public function path(): string;
    public function getDirPath(): string;
}