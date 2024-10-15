<?php declare(strict_types=1);

namespace App\File;


interface PathInterface
{
    public function getDirPath(): string;
    public function getFullPath(): string;
}