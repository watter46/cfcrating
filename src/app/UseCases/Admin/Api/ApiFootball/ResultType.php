<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball;


enum ResultType
{
    case WIN;
    case LOSE;
    case DRAW;

    public function isWin(): bool
    {
        return $this === self::WIN;
    }

    public function isLose(): bool
    {
        return $this === self::LOSE;
    }

    public function isDraw(): bool
    {
        return $this === self::DRAW;
    }

    public static function fromApiValue(?bool $value)
    {
        return match ($value) {
            true => self::WIN,
            false => self::LOSE,
            null => self::DRAW
        };
    }
}