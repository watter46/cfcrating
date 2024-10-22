<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball;

use App\UseCases\Admin\Api\Util\ImageInterface;
use App\File\Image\LeagueImageFile;


class LeagueImage implements ImageInterface
{
    public function __construct(private int $leagueId, private string $image)
    {
        
    }

    public function getId(): int
    {
        return $this->leagueId;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function save(): void
    {
        $file = new LeagueImageFile;

        $file->write($this->leagueId, $this->image);
    }
}