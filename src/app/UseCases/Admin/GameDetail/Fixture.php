<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameDetail;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

use App\Domain\Game\FixtureStatusType;
use App\Domain\Game\FixtureId;
use App\Domain\Game\Season;

class Fixture
{
    private function __construct(
        private FixtureId $fixture_id,
        private Carbon $date,
        private bool $is_end
    ) {
        
    }

    public static function create(Collection $raw_fixture)
    {
        $status = FixtureStatusType::tryFrom($raw_fixture->getDotRaw('status.long')) ?? FixtureStatusType::OtherStatus;

        $date = Carbon::parse($raw_fixture['date'], 'UTC');
        
        return new self(
            FixtureId::create($raw_fixture['id']),
            $date,
            $status->isFinished()
        );
    }

    public function fixtureId()
    {
        return $this->fixture_id;
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
        return $this->is_end;
    }
}