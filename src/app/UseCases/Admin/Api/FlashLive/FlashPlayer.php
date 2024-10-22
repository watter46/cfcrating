<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\FlashLive;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use App\Models\Util\Name;

use function PHPUnit\Framework\isNull;

class FlashPlayer
{
    public function __construct(
        private ?Name $name = null,
        private ?int $number = null,
        private ?string $flash_id = null,
        private ?string $flash_image_id = null
    ) {
        //
    }

    public static function create(
        ?Name $name,
        ?int $number,
        ?string $flash_id,
        ?string $flash_image_id): self
    {
        return new self(
            name: $name,
            number: $number,
            flash_id: $flash_id,
            flash_image_id: $flash_image_id
        );
    }

    public function exist(): bool
    {
        return !is_null($this->flash_id);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getFlashId()
    {
        return $this->flash_id;
    }

    public function getFlashImageId()
    {
        return $this->flash_image_id;
    }
}