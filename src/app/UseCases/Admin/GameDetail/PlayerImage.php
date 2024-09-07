<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameDetail;

use App\UseCases\Admin\GameDetail\ImageInterface;
use File\PlayerImageFile;


class PlayerImage implements ImageInterface
{
    public function __construct(private int $apiPlayerId, private string $image)
    {
        
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
        $file = new PlayerImageFile;

        $file->write($this->apiPlayerId, $this->image);
    }
}