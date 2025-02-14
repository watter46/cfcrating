<?php declare(strict_types=1);

namespace Database\Seeders;

use Database\Seeders\Test\AverageRatingsSeeder;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([ProductionSeeder::class]);
    }
}
