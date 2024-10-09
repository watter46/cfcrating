<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameDetail;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use App\Domain\Player\Name;
use App\Domain\Player\Number;


class FlashPlayer
{
    private const TEAM_NAME = 'Chelsea';

    public function __construct(
        private ?Name $name = null,
        private ?Number $number = null,
        private ?string $flash_id = null,
        private ?string $flash_image_id = null
    ) {

    }

    public static function create(
        ?Name $name,
        ?Number $number,
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

    public static function fromPlayers(Collection $rawPlayersData, string $searchedName)
    {
        $player = $rawPlayersData
            ->recursiveCollect()
            ->filter(fn ($player) =>
                self::isPlayerInChelsea($player['NAME'], $searchedName) ||
                self::matchName(
                    self::toNameOnly($player['NAME']),
                    Name::create($searchedName)
                )
            )
            ->pipe(function (Collection $player) {                
                if ($player->isEmpty()) {
                    return [
                        'name' => null,
                        'number' => null,
                        'flash_id' => null,
                        'flash_image_id' => null
                    ];
                }

                return [
                    'name' => self::toNameOnly($player->first()->get('NAME')),
                    'number' => null,
                    'flash_id' => $player->first()->get('ID'),
                    'flash_image_id' => self::pathToImageId($player->first()->get('IMAGE'))
                ];
            });

        return new self(
            $player['name'],
            $player['number'],
            $player['flash_id'],
            $player['flash_image_id']
        );
        
    }
    
    /**
     * チェルシーの選手で名前が一致するか判定する
     *
     * @param  string $rawName
     * @param  string $searchedName
     * @return bool
     */
    private static function isPlayerInChelsea(string $rawName, string $searchedName)
    {
        $inChelsea = Str::between($rawName, '(', ')') === self::TEAM_NAME;

        if (!$inChelsea) {
            return false;
        }
        
        return self::matchName(self::toNameOnly($rawName), Name::create($searchedName));
    }

    /**
     * 選手名が一致するか判定する
     *
     * @param  Name $rawName
     * @param  Name $searchedName
     * @return bool
     */
    private static function matchName(Name $rawName, Name $searchedName)
    {
        return $rawName->equalsFullName($searchedName) || $rawName->equalsLastName($searchedName);
    }

    private static function toNameOnly(string $rawName)
    {
        $team = '('.self::TEAM_NAME.')';
        
        $name = Str::of($rawName)->remove($team)->squish()->toString();

        return Name::create($name)->swapFirstAndLastName();
    }

    private static function pathToImageId(?string $rawImagePath)
    {
        if (!$rawImagePath) return;
        
        $fileName = Str::afterLast($rawImagePath, '/');

        return Str::beforeLast($fileName, '.png');
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