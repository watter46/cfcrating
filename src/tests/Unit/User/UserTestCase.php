<?php

namespace Tests\Unit\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Carbon;


abstract class UserTestCase extends BaseTestCase
{
    use DatabaseTransactions;

    protected static $migrated = false;

    protected $seeder;
    
    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow('2024-11-11');
        
        if (!self::$migrated) {
            $this->artisan('migrate');

            self::$migrated = true;
        }

        User::factory(2)
            ->state(new Sequence(
                ['id' => 1, 'email' => 'a@gmail.com', 'password' => 'a'],
                ['id' => 2, 'email' => 'b@gmail.com', 'password' => 'b']
            ))->create();

        /** @var Authenticatable $user */
        $user = User::find(1);

        $this->actingAs($user);
                
        if (!$this->seeder) return;

        $this->artisan('db:seed', ['--class' => $this->seeder]);
    }
}