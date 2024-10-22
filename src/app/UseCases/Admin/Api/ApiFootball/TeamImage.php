<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball;

use App\UseCases\Admin\Api\Util\ImageInterface;
use App\File\Image\TeamImageFile;


class TeamImage implements ImageInterface
{
    public function __construct(private int $teamId, private string $image)
    {
        
    }

    public function getId(): int
    {
        return $this->teamId;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function save(): void
    {
        $file = new TeamImageFile;

        $file->write($this->teamId, $this->image);
    }
}