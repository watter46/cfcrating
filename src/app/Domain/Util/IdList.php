<?php declare(strict_types=1);

namespace App\Domain\Util;

use Exception;
use Illuminate\Support\Collection;

use App\Domain\Util\Ulid;


readonly class IdList
{ 
    /**
     * __construct
     *
     * @param  Collection<Ulid> $ids
     * @return void
     */
    private function __construct(private Collection $ids = new Collection)
    {
        //
    }

    public static function create(): static
    {
        return new static;
    }

    public static function reconstruct(Collection $ids)
    {
        return new static($ids);
    }
    
    public function count()
    {
        return $this->ids->count();
    }

    public function get(Ulid $targetId): Ulid
    {
        $id = $this->ids->first(fn(Ulid $id) => $id->equal($targetId));

        if (!$id) {
            throw new Exception('ID not found');
        }

        return $id;
    }
}