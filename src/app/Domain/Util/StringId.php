<?php declare(strict_types=1);

namespace App\Domain\Util;


readonly class StringId
{
    private function __construct(private ?string $id)
    {
        //
    }
    
    public static function create(?string $id = null): static
    {
        return new static($id);
    }

    public function equal(StringId $id)
    {
        return $this->id === $id->get();
    }

    public function get()
    {
        return $this->id;
    }
}