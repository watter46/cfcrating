<?php

namespace Tests\Unit\Admin\UseCases;

use App\Models\Game;
use App\UseCases\Admin\Game\EditGame;
use Database\Seeders\Test\UserTwentyGamesSeeder;
use Tests\Unit\Admin\AdminTestCase;

class EditGameTest extends AdminTestCase
{
    protected $seeder = UserTwentyGamesSeeder::class;
    
    public function test_スコアを変更できる(): void
    {
        $score = Game::find('01JD18AVT9AYM6PQMVHFCM4SRA')->score;
        
        $this->assertSame(1, $score['fulltime']['home']);
        $this->assertSame(1, $score['fulltime']['away']);
        
        $editGame = app(EditGame::class);

        $data = [
            'score' => [
                'penalty' => ['home' => null, 'away' => null],
                'fulltime' => ['home' => 3, 'away' => 5],
                'extratime' => ['home' => null, 'away' => null],
            ]
        ];
        
        $editGame->execute('01JD18AVT9AYM6PQMVHFCM4SRA', $data);

        $edited = Game::find('01JD18AVT9AYM6PQMVHFCM4SRA')->score;

        $this->assertSame(3, $edited['fulltime']['home']);
        $this->assertSame(5, $edited['fulltime']['away']);
    }

    public function test_延長線のスコアを変更できる(): void
    {
        $score = Game::find('01JD18AVT9AYM6PQMVHFCM4SRA')->score;
        
        $this->assertNull($score['extratime']['home']);
        $this->assertNull($score['extratime']['away']);
        
        $editGame = app(EditGame::class);

        $data = [
            'score' => [
                'penalty' => ['home' => null, 'away' => null],
                'fulltime' => ['home' => 1, 'away' => 1],
                'extratime' => ['home' => 0, 'away' => 1],
            ]
        ];
        
        $editGame->execute('01JD18AVT9AYM6PQMVHFCM4SRA', $data);

        $edited = Game::find('01JD18AVT9AYM6PQMVHFCM4SRA')->score;

        $this->assertSame(0, $edited['extratime']['home']);
        $this->assertSame(1, $edited['extratime']['away']);
    }

    public function test_PKのスコアを変更できる(): void
    {
        $score = Game::find('01JD18AVT9AYM6PQMVHFCM4SRA')->score;
        
        $this->assertNull($score['penalty']['home']);
        $this->assertNull($score['penalty']['away']);
        
        $editGame = app(EditGame::class);

        $data = [
            'score' => [
                'penalty' => ['home' => 3, 'away' => 5],
                'fulltime' => ['home' => 1, 'away' => 1],
                'extratime' => ['home' => 0, 'away' => 0],
            ]
        ];
        
        $editGame->execute('01JD18AVT9AYM6PQMVHFCM4SRA', $data);

        $edited = Game::find('01JD18AVT9AYM6PQMVHFCM4SRA')->score;

        $this->assertSame(0, $edited['extratime']['home']);
        $this->assertSame(0, $edited['extratime']['away']);
        $this->assertSame(3, $edited['penalty']['home']);
        $this->assertSame(5, $edited['penalty']['away']);
    }

    public function test_試合の日時を変更できる(): void
    {
        $started_at = Game::find('01JD18AVT9AYM6PQMVHFCM4SRA')->started_at;
        
        $this->assertSame('2024-11-04 18:10:00', $started_at);
        
        $editGame = app(EditGame::class);

        $data = ['started_at' => "2024-11-05 20:00:00"];
        
        $editGame->execute('01JD18AVT9AYM6PQMVHFCM4SRA', $data);

        $edited = Game::find('01JD18AVT9AYM6PQMVHFCM4SRA')->started_at;

        $this->assertSame('2024-11-05 20:00:00', $edited);
    }

    public function test_試合の勝敗を変更できる(): void
    {
        $is_winner = Game::find('01JD18AVT9AYM6PQMVHFCM4SRA')->is_winner;
        
        $this->assertNull($is_winner);
        
        $editGame = app(EditGame::class);

        $data = ['is_winner' => true];
        
        $editGame->execute('01JD18AVT9AYM6PQMVHFCM4SRA', $data);

        $win = Game::find('01JD18AVT9AYM6PQMVHFCM4SRA')->is_winner;

        $this->assertTrue($win);

        $data = ['is_winner' => false];
        
        $editGame->execute('01JD18AVT9AYM6PQMVHFCM4SRA', $data);

        $lose = Game::find('01JD18AVT9AYM6PQMVHFCM4SRA')->is_winner;

        $this->assertFalse($lose);
    }
}