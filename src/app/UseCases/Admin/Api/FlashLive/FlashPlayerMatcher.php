<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\FlashLive;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use App\Models\Util\Name;
use Exception;

class FlashPlayerMatcher
{
    private const TEAM_NAME = 'Chelsea';
    
    private Name $searchName;
    
    public function __construct(private Collection $rawPlayers, string $searchName)
    {
        $this->searchName = Name::create($searchName);
    }

    public function match()
    {
        $teamMatchPlayer = $this->rawPlayers
            ->first(function (Collection $player) {
                return $this->isChelseaTeam($player->get('NAME')) &&
                    $this->isNameMatching($this->extractTeam($player->get('NAME')));
            });

        if ($teamMatchPlayer) {
            $player = $this->extractTeam($teamMatchPlayer->get('NAME'));
            
            return new FlashPlayer(
                name: $this->replaceNameIfDifferent($player),
                flash_id: $teamMatchPlayer->get('ID'),
                flash_image_id: $this->pathToImageId($teamMatchPlayer->get("IMAGE"))
            );
        }

        $nameMatchPlayer = $this->rawPlayers
            ->first(function (Collection $player) {
                return $this->isNameMatching($this->extractTeam($player->get('NAME')));
            });

        if ($nameMatchPlayer) {
            $player = $this->extractTeam($nameMatchPlayer->get('NAME'));

            return new FlashPlayer(
                name: $this->replaceNameIfDifferent($player),
                flash_id: $nameMatchPlayer->get('ID'),
                flash_image_id: $this->pathToImageId($nameMatchPlayer->get("IMAGE"))
            );
        }

        return new FlashPlayer;
    }

    private function extractTeam(string $name)
    {
        $extractedName = Str::of($name)->before(' (')->toString();

        return Name::create($extractedName);
    }

    private function isNameMatching(Name $name)
    {
        $equal = $this->searchName->equalsFullName($name) ||
            $this->searchName->equalsShortenName($name);

        if ($equal) {
            return true;
        }

        $swapName = $name->swapFirstAndLastName();

        return $this->searchName->equalsFullName($swapName) ||
            $this->searchName->equalsShortenName($swapName);
    }

    private function isChelseaTeam(string $name)
    {
        $team = Str::between($name, '(', ')');
        
        return $team === self::TEAM_NAME;
    }
    
    /**
     * 名前を更新する必要があるならAPIから取得した名前に置き換える
     *
     * @param  Name $name
     * @return Name
     */
    private function replaceNameIfDifferent(Name $name)
    {
        if (!$this->searchName->isShorten()) {
            return $this->searchName;
        }

        if ($name->equalsShortenName($this->searchName)) {
            return $name;
        };

        return $name->swapFirstAndLastName();
    }

    private function pathToImageId(?string $rawImagePath)
    {
        if (!$rawImagePath) return;
        
        $fileName = Str::afterLast($rawImagePath, '/');

        return Str::beforeLast($fileName, '.png');
    }
}