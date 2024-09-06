<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use App\UseCases\Admin\GameDetail\ImageInterface;

interface ImageRepositoryInterface
{
    public function save(ImageInterface $image): void;
}