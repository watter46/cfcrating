<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\FlashLive;

use Intervention\Image\ImageManager;

use App\UseCases\Admin\Api\Util\ImageInterface;
use App\File\Image\PlayerImageFile;


class PlayerImage implements ImageInterface
{
    public function __construct(private int $apiPlayerId, private string $image)
    {
        //
    }

    public function getId(): int
    {
        return $this->apiPlayerId;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function save(): void
    {
        $file = new PlayerImageFile(app(ImageManager::class));

        $file->write($this->apiPlayerId, $this->image);
    }
}