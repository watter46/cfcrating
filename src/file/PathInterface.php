<?php declare(strict_types=1);

namespace File;


interface PathInterface
{
    public function getDirPath(): string;
    public function getFullPath(): string;
}