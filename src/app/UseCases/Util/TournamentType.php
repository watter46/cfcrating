<?php declare(strict_types=1);

namespace App\UseCases\Util;


enum TournamentType: int
{
    case ALL = 0;
    case PREMIER_LEAGUE = 39;
    case FA_CUP = 45;
    case LEAGUE_CUP = 48;
    
    /**
     * シーズンのTournamentのみ取得する
     *
     * @return array<int>
     */
    public static function inSeasonTournaments(): array
    {
        return [
            self::PREMIER_LEAGUE->value,
            self::FA_CUP->value,
            self::LEAGUE_CUP->value
        ];
    }

    public function isAll(): bool
    {
        return $this === self::ALL;
    }

    /**
     * 表示用に変換する
     *
     * @return string
     */
    public function toText(): string
    {
        return match($this) {
            self::ALL => '-',
            self::PREMIER_LEAGUE => 'Premier League',
            self::FA_CUP => 'FA Cup',
            self::LEAGUE_CUP => 'League Cup'
        };
    }

    public static function toLabels()
    {
        return collect(self::cases())
            ->map(function (TournamentType $type) {
                return [
                    'id' => $type->value,
                    'label' => $type->toText()
                ];
            });
    }

    public function toQueryString(): string
    {
        return match($this) {
            self::ALL => '',
            self::PREMIER_LEAGUE => 'premier_league',
            self::FA_CUP => 'fa_cup',
            self::LEAGUE_CUP => 'league_cup'
        };
    }

    public static function fromTournamentId(int $tournamentId)
    {
        $valid = self::tryFrom($tournamentId);

        if (!$valid) {
            return self::ALL;
        }

        return $valid;
    }
}