<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\Util;

use App\UseCases\Admin\Api\Util\ImageInterface;


interface ImageRepositoryInterface
{
    public function save(ImageInterface $image): void;
}