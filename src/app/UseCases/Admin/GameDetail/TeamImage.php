<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameDetail;

use App\UseCases\Admin\GameDetail\ImageInterface;
use File\TeamImageFile;


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