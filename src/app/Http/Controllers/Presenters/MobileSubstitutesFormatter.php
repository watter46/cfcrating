<?php declare(strict_types=1);

namespace App\Http\Controllers\Presenters;

use Illuminate\Support\Collection;


readonly class MobileSubstitutesFormatter
{    
    private Collection $result;

    public function format(Collection $substitutes)
    {
        $this->chunk($substitutes->values(), collect());

        return $this->result;
    }

    private function chunk(
        Collection $substitutes,
        Collection $result = new Collection(),
        ChunkType $chunk = ChunkType::BigChunk)
    {
        if ($substitutes->isEmpty()) {
            return $this->result = $result;
        }

        $remainingItems = $substitutes->splice($chunk->value);
        $resultItems    = $result->push($substitutes);

        $this->chunk($remainingItems, $resultItems, $chunk->changeSize());
    }
}