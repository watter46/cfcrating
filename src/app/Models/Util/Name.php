<?php declare(strict_types=1);

namespace App\Models\Util;

use Illuminate\Support\Str;


readonly class Name
{
    public function __construct(private string $firstName, private ?string $lastName = null)
    {
        //
    }

    public static function create(string $name): self
    {
        $transliterated = Str::ascii($name);
        
        $first = Str::of($transliterated)->explode(' ')->first();
        $last  = Str::of($transliterated)->explode(' ')->last();

        return new self(
            $first,
            $first !== $last ? $last : null
        );
    }

    public function equalsFullName(Name $name)
    {
        return $this->getFullName() === $name->getFullName();
    }

    public function equalsShortenName(Name $name)
    {
        return $this->getShortenName() === $name->getShortenName();
    }

    public function equalsLastName(Name $name)
    {
        return $this->getLastName() === $name->getLastName();
    }

    public function swapFirstAndLastName(): self
    {    
        if (!$this->lastName) {
            return $this;
        }
        
        return new self($this->lastName, $this->firstName);
    }

    public function isShorten(): bool
    {
        return preg_match('/^[A-Z]\.$/', $this->getFirstName()) === 1;
    }

    public function getFullName(): string
    {
        if (!$this->lastName) {
            return $this->getFirstName();
        }
        
        return $this->getFirstName().' '.$this->getLastName();
    }

    public function getShortenName(): string
    {
        if (!$this->lastName) {
            return $this->getFirstName();
        }
        
        $shortenFirstName = Str::substr($this->getFirstName(), 0, 1);

        return $shortenFirstName.'. '.$this->getLastName();
    }

    private function getFirstName(): string
    {
        return $this->firstName;
    }

    private function getLastName(): ?string
    {
        return $this->lastName;
    }
}