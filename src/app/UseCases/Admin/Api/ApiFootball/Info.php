<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

use App\Models\Util\Season;
use App\UseCases\Admin\Api\ApiFootball\FixtureStatusType;


class Info
{
    private function __construct(
        private int $fixtureId,
        private Carbon $date,
        private bool $isEnd
    ) {
        
    }

    public static function create(Collection $rawFixture)
    {
        $status = FixtureStatusType::tryFrom($rawFixture->getDotRaw('status.long')) ?? FixtureStatusType::OtherStatus;

        $date = Carbon::parse($rawFixture['date'], 'UTC');
        
        return new self(
            $rawFixture['id'],
            $date,
            $status->isFinished()
        );
    }

    public function fixtureId()
    {
        return $this->fixtureId;
    }

    public function getSeason()
    {
        return Season::fromDate($this->date);
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getIsEnd()
    {
        return $this->isEnd;
    }
}