<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameDetail;


interface ImageInterface
{
    public function getId(): int;
    public function getImage(): string;
    public function save(): void;
}