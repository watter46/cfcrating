<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Auth\Authenticatable;


abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;

    protected static $migrated = false;

    protected $seeder;
    
    public function setUp(): void
    {
        parent::setUp();
        
        if (!self::$migrated) {
            $this->artisan('migrate');

            self::$migrated = true;
        }

        /** @var Authenticatable $user */
        $user = User::factory()->create();

        $this->actingAs($user);
                
        if (!$this->seeder) return;

        $this->artisan('db:seed', ['--class' => $this->seeder]);
    }
}
