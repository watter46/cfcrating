<?php declare(strict_types=1);

namespace App\Domain\Util;

use Exception;
use Illuminate\Support\Str;


readonly class Ulid
{
    private function __construct(private string $id)
    {
        if (!$this->isUlid()) {
            throw new Exception('id is not ulid');
        }
    }
    
    public static function create(string $id): static
    {
        return new static($id);
    }

    public function equal(Ulid $id)
    {
        return $this->id === $id->get();
    }

    public function get()
    {
        return $this->id;
    }

    private function isUlid()
    {
        return Str::isUlid($this->id);
    }
}