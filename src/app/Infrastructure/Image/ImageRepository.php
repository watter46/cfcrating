<?php declare(strict_types=1);

namespace App\Infrastructure\Image;

use App\UseCases\Admin\GameDetail\ImageInterface;
use App\UseCases\Admin\ImageRepositoryInterface;


class ImageRepository implements ImageRepositoryInterface
{
    public function save(ImageInterface $image): void
    {
        $image->save();
    }
}