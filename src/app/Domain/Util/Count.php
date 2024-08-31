<?php declare(strict_types=1);

namespace App\Domain\Util;


readonly class Count
{
    protected int $count;
    
    private function __construct(int $count = 0)
    {
        $this->count = $count;
    }

    public static function create(): static
    {
        return new static;
    }

    public static function reconstruct(int $count)
    {
        return new static($count);
    }

    public function increment()
    {
        return new static($this->count++);
    }

    public function value()
    {
        return $this->count;
    }
}