<?php declare(strict_types=1);

namespace App\Domain\Util;


readonly class IntegerId
{
    private function __construct(private int $id)
    {
        //
    }
    
    public static function create(int $id): static
    {
        return new static($id);
    }

    public function equal(integerId $id)
    {
        return $this->id === $id->get();
    }

    public function get()
    {
        return $this->id;
    }
}