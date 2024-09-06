<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameDetail;

enum LineupType: string
{
    case STARTER = 'startXI';
    case SUBSTITUTE = 'substitutes';

    public function isStarter()
    {
        return $this === self::STARTER;
    }
}