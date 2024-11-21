<?php

namespace Tests\Unit\Guest;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Carbon;


abstract class GuestTestCase extends BaseTestCase
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

        if (!$this->seeder) return;

        $this->artisan('db:seed', ['--class' => $this->seeder]);
    }
}
