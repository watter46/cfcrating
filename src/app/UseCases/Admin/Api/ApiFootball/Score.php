<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball;

use Illuminate\Support\Collection;


readonly class Score
{
    private function __construct(private Collection $score)
    {
        
    }

    public static function create(Collection $rawScore): self
    {
        return new self($rawScore->except('halftime'));
    }

    public function get()
    {
        return $this->score;
    }
}