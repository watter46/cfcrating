<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

use App\Models\User;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->count(5)
            ->state(new Sequence(
                ['email' => 'a@gmail.com', 'password' => 'a'],
                ['email' => 'b@gmail.com', 'password' => 'b'],
                ['email' => 'c@gmail.com', 'password' => 'c'],
                ['email' => 'd@gmail.com', 'password' => 'd'],
                ['email' => 'e@gmail.com', 'password' => 'e'],
            ))
            ->create();
    }
}