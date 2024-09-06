<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameDetail;

use App\UseCases\Admin\GameDetail\ImageInterface;
use File\LeagueImageFile;


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