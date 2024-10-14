<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameDetail;

use Illuminate\Support\Collection;


class Score
{
    private function __construct(private Collection $score)
    {
        
    }

    public static function create(Collection $rawScore): self
    {        
        $score = $rawScore->except('halftime');

        return new self($score);
    }

    public function toCollect()
    {
        return $this->score;
    }

    public function toJson()
    {
        return $this->score->toJson();
    }
}