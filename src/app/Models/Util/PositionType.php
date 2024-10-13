<?php declare(strict_types=1);

namespace App\Models\Util;


enum PositionType: string
{
    case FW  = 'F';
    case MID = 'M';
    case DEF = 'D';
    CASE GK  = 'G';

    public function text()
    {
        return match ($this) {
            self::FW  => 'Forward',
            self::MID => 'Midfielder',
            self::DEF => 'Defender',
            self::GK  => 'Goalkeeper'
        };
    }

    public static function fromMix(string $position)
    {
        return match ($position) {
            'Forward'   , 'FW' , 'F' => self::FW,
            'Midfielder', 'MID', 'M' => self::MID,
            'Defender'  , 'DEF', 'D' => self::DEF,
            'Goalkeeper', 'GK' , 'G' => self::GK,
        };
    }
}