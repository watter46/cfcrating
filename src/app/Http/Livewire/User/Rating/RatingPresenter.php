<?php declare(strict_types=1);

namespace App\Http\Livewire\User\Rating;


class RatingPresenter
{
    public function getRatingRanges(array $player)
    {
        $rateCount = $player['rateCount'];
        $rateLimit = $player['rateLimit'];
        $momCount = $player['momCount'];
        $momLimit = $player['momLimit'];
        
        return [
            'rateCountRange' => $this->getRateCountRange($rateCount),
            'remainingRateCountRange' => $this->getRemainingRateCountRange($rateCount, $rateLimit),
            'momCountRange' => $this->getMomCountRange($momCount),
            'remainingMomCountRange' => $this->getRemainingMomCountRange($momCount, $momLimit),
        ];
    }

    private function getRemainingRateCountRange(int $rateCount, int $rateLimit): array
    {
        $remainingCount = $rateLimit - $rateCount;

        return $remainingCount ? range(1, $rateLimit - $rateCount) : [];
    }

    private function getRateCountRange(int $rateCount): array
    {
        return $rateCount ? range(1, $rateCount) : [];
    }

    private function getRemainingMomCountRange(int $momCount, int $momLimit): array
    {
        $remainingMomCount = $momLimit - $momCount;

        return $remainingMomCount ? range(1, $remainingMomCount) : [];
    }

    private function getMomCountRange(int $momCount): array
    {
        return $momCount ? range(1, $momCount) : [];
    }
}