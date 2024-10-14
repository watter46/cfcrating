<?php declare(strict_types=1);

namespace App\Infrastructure\Image;

use App\UseCases\Admin\Api\Util\ImageInterface;
use App\UseCases\Admin\Api\Util\ImageRepositoryInterface;


class ImageRepository implements ImageRepositoryInterface
{
    public function save(ImageInterface $image): void
    {
        $image->save();
    }
}