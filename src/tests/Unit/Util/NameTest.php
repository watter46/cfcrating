<?php declare(strict_types=1);

namespace Tests\Unit\Util;

use Tests\TestCase;

use App\Models\Util\Name;


class NameTest extends TestCase
{
    const PLAYER_NAME = 'João Félix';
    const SWAP_PLAYER_NAME = 'Félix João';
    const TEAM_Player_NAME = 'João Félix (Chelsea)';
    const TEAM_SWAP_Player_NAME = 'Félix João (Chelsea)';
    
    
    public function test_NameクラスからnameとnamePlainを作成できる()
    {
        $name = Name::create(self::PLAYER_NAME);

        $this->assertSame('João Félix', $name->getFullName());
        $this->assertSame('Joao Felix', $name->getFullNamePlain());
    }
    
    public function test_swapしている時でも同じ名前と判定される(): void
    {
        $name1 = Name::create(self::PLAYER_NAME);
        $name2 = Name::create(self::SWAP_PLAYER_NAME);

        $this->assertTrue($name1->equal($name2));
    }
}